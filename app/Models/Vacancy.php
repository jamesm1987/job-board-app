<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = [
        'title',
        'employment_type',
        'job_location_type',
        'location',
        'salary_frequency',
        'salary',
        'full_description',
        'employer_id',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
