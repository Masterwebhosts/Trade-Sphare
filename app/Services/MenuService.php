<?php

namespace App\Services;

class MenuService
{
    public function get(string $role): array
    {
        return match ($role) {

            'admin' => [
    ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
    ['label' => 'Users', 'route' => 'admin.users.index'],
    ['label' => 'Campaigns', 'route' => 'admin.campaigns.index'],
    ['label' => 'Ads', 'route' => 'admin.ads.index'],
    ['label' => 'Withdrawals', 'route' => 'admin.withdrawals.index'],
],

         'publisher' => [
    ['label' => 'Dashboard', 'route' => 'publisher.dashboard'],
    ['label' => 'Wallet', 'route' => 'publisher.wallet.index'],
    ['label' => 'Earnings', 'route' => 'publisher.earnings.index'],
],

            'publisher' => [
                ['label' => 'Dashboard', 'route' => 'publisher.dashboard'],
                ['label' => 'Wallet', 'route' => 'publisher.wallet.index'],
                ['label' => 'Earnings', 'route' => 'publisher.earnings'],
            ],

            default => [],
        };
    }
}
