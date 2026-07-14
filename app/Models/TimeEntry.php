<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'collaborator_id',
        'establishment',
        'entry_time',
        'exit_time',
        'presence',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }
}