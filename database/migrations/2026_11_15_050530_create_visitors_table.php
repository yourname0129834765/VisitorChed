<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitors')) {
            return;
        }

        if (Schema::hasTable('patients')) {
            Schema::rename('patients', 'visitors');

            if (Schema::hasColumn('visitors', 'patient_number')) {
                Schema::table('visitors', function (Blueprint $table): void {
                    $table->renameColumn('patient_number', 'visitor_number');
                });
            }

            $legacyColumns = array_values(array_filter(
                ['birth_date', 'sex'],
                fn (string $column): bool => Schema::hasColumn('visitors', $column),
            ));

            if ($legacyColumns !== []) {
                Schema::table('visitors', function (Blueprint $table) use ($legacyColumns): void {
                    $table->dropColumn($legacyColumns);
                });
            }

            Schema::table('visitors', function (Blueprint $table): void {
                $table->text('purpose_of_visit')->nullable();
                $table->string('person_to_visit', 150)->nullable();
                $table->string('department', 150)->nullable();
                $table->date('visit_date')->nullable();
                $table->time('time_in')->nullable();
                $table->time('time_out')->nullable();
                $table->string('status', 20)->default('Checked In');
                $table->index(['visit_date', 'time_in']);
            });

            return;
        }

        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_number', 50)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('contact_number', 30)->nullable();
            $table->text('address')->nullable();
            $table->text('purpose_of_visit');
            $table->string('person_to_visit', 150);
            $table->string('department', 150);
            $table->date('visit_date');
            $table->time('time_in');
            $table->time('time_out')->nullable();
            $table->string('status', 20)->default('Checked In');
            $table->timestamps();
            $table->index(['visit_date', 'time_in']);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('visitors')) {
            return;
        }

        if (Schema::hasIndex('visitors', 'visitors_visit_date_time_in_index')) {
            Schema::table('visitors', function (Blueprint $table): void {
                $table->dropIndex('visitors_visit_date_time_in_index');
            });
        }

        $visitorColumns = array_values(array_filter(
            [
                'purpose_of_visit',
                'person_to_visit',
                'department',
                'visit_date',
                'time_in',
                'time_out',
                'status',
            ],
            fn (string $column): bool => Schema::hasColumn('visitors', $column),
        ));

        if ($visitorColumns !== []) {
            Schema::table('visitors', function (Blueprint $table) use ($visitorColumns): void {
                $table->dropColumn($visitorColumns);
            });
        }

        Schema::table('visitors', function (Blueprint $table): void {
            if (! Schema::hasColumn('visitors', 'birth_date')) {
                $table->date('birth_date')->nullable();
            }

            if (! Schema::hasColumn('visitors', 'sex')) {
                $table->string('sex', 20)->nullable();
            }

            if (Schema::hasColumn('visitors', 'visitor_number')) {
                $table->renameColumn('visitor_number', 'patient_number');
            }
        });

        Schema::rename('visitors', 'patients');
    }
};
