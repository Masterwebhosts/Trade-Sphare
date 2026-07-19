<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'reviewed_by',
        'status',
        'reason',
    ];

    protected $casts = [
        'ad_id' => 'integer',
        'reviewed_by' => 'integer',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
