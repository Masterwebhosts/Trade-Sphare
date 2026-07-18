<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\Cache;

class DashboardCacheService
{
    private int $ttl = 30; // 30 seconds cache (real-time balanced)

    /*
    |--------------------------------------------------------------------------
    | CACHE KEY BUILDER
    |--------------------------------------------------------------------------
    */
    private function key(string $type, int|string|null $id = null): string
    {
        return match ($type) {
            'admin' => "dashboard:admin",
            'advertiser' => "dashboard:advertiser:$id",
            'publisher' => "dashboard:publisher:$id",
            default => "dashboard:global:$type",
        };
    }

    /*
    |--------------------------------------------------------------------------
    | GET FROM CACHE OR COMPUTE
    |--------------------------------------------------------------------------
    */
    public function remember(string $type, int|string|null $id, callable $callback): mixed
    {
        $key = $this->key($type, $id);

        return Cache::remember($key, $this->ttl, function () use ($callback) {
            return $callback();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FLUSH SINGLE DASHBOARD CACHE
    |--------------------------------------------------------------------------
    */
    public function forget(string $type, int|string|null $id): void
    {
        Cache::forget($this->key($type, $id));
    }

    /*
    |--------------------------------------------------------------------------
    | FLUSH ALL DASHBOARDS (DANGER RESET)
    |--------------------------------------------------------------------------
    */
    public function flushAll(): void
    {
        Cache::flush();
    }
}