<?php

namespace App\View\Navigation;

class MenuProvider
{
    public static function forRole(string $role): array
    {
        return match ($role) {

            'publisher' => [
                ['label' => 'لوحة التحكم', 'route' => 'publisher.dashboard'],
                ['label' => 'المناطق', 'route' => 'publisher.zones.index'],
                ['label' => 'الأرباح', 'route' => 'publisher.earnings.index'],
                ['label' => 'المحفظة', 'route' => 'publisher.wallet.index'],
                ['label' => 'السحوبات', 'route' => 'publisher.withdrawals.index'],
            ],

            'advertiser' => [
                ['label' => 'لوحة التحكم', 'route' => 'advertiser.dashboard'],
                ['label' => 'الحملات', 'route' => 'advertiser.campaigns.index'],
                ['label' => 'الإعلانات', 'route' => 'advertiser.ads.index'],
                ['label' => 'الإحصائيات', 'route' => 'advertiser.stats.index'],
                ['label' => 'المحفظة', 'route' => 'advertiser.topup.create'],
            ],

            'admin' => [
                ['label' => 'لوحة التحكم', 'route' => 'admin.dashboard'],
                ['label' => 'المستخدمون', 'route' => 'admin.users.index'],
                ['label' => 'الحملات', 'route' => 'admin.campaigns.index'],
                ['label' => 'الإعلانات', 'route' => 'admin.ads.index'],
                ['label' => 'الشحن', 'route' => 'admin.topups.index'],
            ],

            default => [],
        };
    }
}
