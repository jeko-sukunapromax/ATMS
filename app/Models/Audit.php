<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'office_uuid',
        'start_date',
        'end_date',
        'status',
        'auditor_id',
    ];

    /**
     * Get the findings for the audit.
     */
    public function findings()
    {
        return $this->hasMany(Finding::class);
    }

    /**
     * Get the user who conducted the audit.
     */
    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}
