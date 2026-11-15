<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VisitorController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim((string) $request->input('search', ''));

        $visitors = Visitor::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('visitor_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%")
                        ->orWhere('purpose_of_visit', 'like', "%{$search}%")
                        ->orWhere('person_to_visit', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('visit_date')
            ->orderByDesc('time_in')
            ->paginate(10)
            ->withQueryString();

        return view('visitors.index', [
            'visitors' => $visitors,
            'search' => $search,
            'totalVisitors' => Visitor::count(),
        ]);
    }

    public function create(): View
    {
        return view('visitors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Visitor::create($request->validate($this->validationRules()));

        return redirect()
            ->route('visitors.index')
            ->with('success', 'Visitor registered successfully.');
    }

    public function show(Visitor $visitor): View
    {
        return view('visitors.show', compact('visitor'));
    }

    public function edit(Visitor $visitor): View
    {
        return view('visitors.edit', compact('visitor'));
    }

    public function update(Request $request, Visitor $visitor): RedirectResponse
    {
        $visitor->update($request->validate($this->validationRules($visitor)));

        return redirect()
            ->route('visitors.index')
            ->with('success', 'Visitor record updated successfully.');
    }

    public function destroy(Visitor $visitor): RedirectResponse
    {
        $visitor->delete();

        return redirect()
            ->route('visitors.index')
            ->with('success', 'Visitor record deleted successfully.');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function validationRules(?Visitor $visitor = null): array
    {
        $visitorNumber = Rule::unique('visitors', 'visitor_number');

        if ($visitor !== null) {
            $visitorNumber->ignore($visitor->id);
        }

        return [
            'visitor_number' => ['required', 'string', 'max:50', $visitorNumber],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:2000'],
            'purpose_of_visit' => ['required', 'string', 'max:2000'],
            'person_to_visit' => ['required', 'string', 'max:150'],
            'department' => ['required', 'string', 'max:150'],
            'visit_date' => ['required', 'date_format:Y-m-d'],
            'time_in' => ['required', 'date_format:H:i'],
            'time_out' => [
                'nullable',
                'required_if:status,Checked Out',
                'date_format:H:i',
                'after_or_equal:time_in',
            ],
            'status' => ['required', Rule::in(['Checked In', 'Checked Out'])],
        ];
    }
}
