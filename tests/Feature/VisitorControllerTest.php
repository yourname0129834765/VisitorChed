<?php

namespace Tests\Feature;

use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class VisitorControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_home_page_and_unknown_routes_redirect_back_to_the_records(): void
    {
        $this->get(route('home'))
            ->assertOk();

        $this->get('/missing-route')
            ->assertRedirect(route('visitors.index'));
    }

    public function test_registration_saves_a_visitor_and_redirects_to_the_records(): void
    {
        $visitorData = $this->validVisitorData();

        $response = $this->post(route('visitors.store'), $visitorData);

        $response->assertRedirect(route('visitors.index'));
        $this->assertDatabaseHas('visitors', [
            'visitor_number' => 'V-1001',
            'first_name' => 'Avery',
            'purpose_of_visit' => 'Appointment',
            'time_in' => '09:30',
            'status' => 'Checked In',
        ]);
    }

    public function test_registration_rejects_missing_required_visitor_information(): void
    {
        $response = $this->post(route('visitors.store'), []);

        $response->assertSessionHasErrors([
            'visitor_number' => 'The visitor number field is required.',
            'first_name',
            'last_name',
            'purpose_of_visit',
            'person_to_visit',
            'department',
            'visit_date',
            'time_in',
            'status',
        ]);
        $this->assertDatabaseCount('visitors', 0);
    }

    public function test_registration_rejects_a_duplicate_visitor_number(): void
    {
        Visitor::factory()->create(['visitor_number' => 'V-1001']);

        $response = $this->post(route('visitors.store'), $this->validVisitorData());

        $response->assertSessionHasErrors('visitor_number');
        $this->assertDatabaseCount('visitors', 1);
    }

    public function test_registration_and_edit_pages_render_the_visitor_form(): void
    {
        $visitor = Visitor::factory()->create();

        $this->get(route('visitors.create'))
            ->assertOk()
            ->assertSee('name="visitor_number"', false)
            ->assertSee('name="purpose_of_visit"', false);

        $this->get(route('visitors.edit', $visitor))
            ->assertOk()
            ->assertSee('name="visitor_number"', false)
            ->assertSee('name="time_out"', false);
    }

    public function test_checked_out_visitors_must_include_a_time_out(): void
    {
        $visitorData = $this->validVisitorData();
        $visitorData['status'] = 'Checked Out';

        $response = $this->post(route('visitors.store'), $visitorData);

        $response->assertSessionHasErrors('time_out');
        $this->assertDatabaseCount('visitors', 0);
    }

    public function test_checked_out_visitors_must_have_a_time_out_after_time_in(): void
    {
        $visitorData = $this->validVisitorData();
        $visitorData['status'] = 'Checked Out';
        $visitorData['time_out'] = '09:00';

        $response = $this->post(route('visitors.store'), $visitorData);

        $response->assertSessionHasErrors('time_out');
        $this->assertDatabaseCount('visitors', 0);
    }

    public function test_records_page_displays_total_and_searches_visitor_details(): void
    {
        Visitor::factory()->create([
            'visitor_number' => 'V-1001',
            'first_name' => 'Avery',
            'contact_number' => '555-0101',
            'purpose_of_visit' => 'Records request',
            'person_to_visit' => 'Jordan Lee',
            'department' => 'Admissions',
        ]);
        Visitor::factory()->create([
            'visitor_number' => 'V-1002',
            'first_name' => 'Taylor',
            'department' => 'Finance',
        ]);

        foreach (['V-1001', 'Avery', '555-0101', 'Records request', 'Jordan Lee', 'Admissions'] as $search) {
            $response = $this->get(route('visitors.index', ['search' => $search]));

            $response->assertOk();
            $response->assertSee('Total Registered Visitors');
            $response->assertSee('<strong class="total">2</strong>', false);
            $response->assertSee('V-1001');
            $response->assertDontSee('V-1002');
        }
    }

    public function test_visitor_details_can_be_viewed_and_updated(): void
    {
        $visitor = Visitor::factory()->create();

        $this->get(route('visitors.show', $visitor))
            ->assertOk()
            ->assertSee($visitor->visitor_number)
            ->assertSee($visitor->purpose_of_visit);

        $updatedData = $this->validVisitorData();
        $updatedData['visitor_number'] = $visitor->visitor_number;
        $updatedData['purpose_of_visit'] = 'Delivering documents';
        $updatedData['status'] = 'Checked Out';
        $updatedData['time_out'] = '10:15';

        $response = $this->put(route('visitors.update', $visitor), $updatedData);

        $response->assertRedirect(route('visitors.index'));
        $this->assertDatabaseHas('visitors', [
            'id' => $visitor->id,
            'purpose_of_visit' => 'Delivering documents',
            'time_out' => '10:15',
            'status' => 'Checked Out',
        ]);
    }

    public function test_visitor_records_can_be_deleted(): void
    {
        $visitor = Visitor::factory()->create();

        $response = $this->delete(route('visitors.destroy', $visitor));

        $response->assertRedirect(route('visitors.index'));
        $this->assertDatabaseMissing('visitors', ['id' => $visitor->id]);
    }

    /**
     * @return array<string, string>
     */
    private function validVisitorData(): array
    {
        return [
            'visitor_number' => 'V-1001',
            'first_name' => 'Avery',
            'last_name' => 'Morgan',
            'contact_number' => '555-0101',
            'address' => '12 Sample Street',
            'purpose_of_visit' => 'Appointment',
            'person_to_visit' => 'Jordan Lee',
            'department' => 'Admissions',
            'visit_date' => '2026-11-15',
            'time_in' => '09:30',
            'time_out' => '',
            'status' => 'Checked In',
        ];
    }
}
