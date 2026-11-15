<?php

namespace App\Models;

use Database\Factories\VisitorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /** @use HasFactory<VisitorFactory> */
    use HasFactory;

    protected $fillable = [
        'visitor_number',
        'first_name',
        'last_name',
        'contact_number',
        'address',
        'purpose_of_visit',
        'person_to_visit',
        'department',
        'visit_date',
        'time_in',
        'time_out',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
        ];
    }
}
