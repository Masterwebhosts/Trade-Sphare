<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'role',
        'status',
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Laravel Auth password column override
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    /**
     * تلقائيًا: عند تعيين password يتم تخزينه في password_hash
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }

    /**
     * العلاقات
     */
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    /**
     * Roles helpers
     */
    public function isAdvertiser(): bool
    {
        return $this->role === 'advertiser';
    }

    public function isPublisher(): bool
    {
        return $this->role === 'publisher';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}