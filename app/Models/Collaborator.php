<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'establishment',
        'establishment_id',
    ];

    public function establishmentRelation()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }
}