<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    protected $fillable = [
        'audit_id',
        'title',
        'description',
        'risk_level',
        'status',
    ];

    /**
     * Get the audit that owns the finding.
     */
    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }

    /**
     * Get the recommendations for the finding.
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
