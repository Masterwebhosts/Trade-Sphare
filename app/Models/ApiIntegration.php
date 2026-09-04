<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiIntegration extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'api_key',
        'api_secret_hash',
        'status',
        'permissions',
        'rate_limit',
        'allowed_ips',
        'last_used_at',
        'approved_at',
        'revoked_at',
        'created_by',
    ];

    protected $casts = [
        'permissions' => 'array',
        'allowed_ips' => 'array',
        'last_used_at' => 'datetime',
        'approved_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }
}
