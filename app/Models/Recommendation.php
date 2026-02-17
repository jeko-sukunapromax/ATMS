<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'finding_id',
        'description',
        'status',
        'due_date',
    ];

    /**
     * Get the finding that owns the recommendation.
     */
    public function finding()
    {
        return $this->belongsTo(Finding::class);
    }
}
