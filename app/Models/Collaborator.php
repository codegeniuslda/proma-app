<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'workload_hours',
        'establishment',
    ];

    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }
}