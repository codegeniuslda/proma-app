<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstablishmentManagement extends Model
{
    use HasFactory;

    protected $table = 'establishment_managements';

    protected $fillable = [
        'collaborator_id',
        'closed_by_collaborator_id',
        'date',
        'opened_at',
        'closed_at',
        'establishment_state',
        'description',
        'description_status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function closedByCollaborator()
    {
        return $this->belongsTo(Collaborator::class, 'closed_by_collaborator_id');
    }
}