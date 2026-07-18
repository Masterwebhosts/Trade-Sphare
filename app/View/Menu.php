<?php

namespace App\View;

class Menu
{
    public static function items(): array
    {
        return [
            'admin' => [
                [
                    'label' => 'Dashboard',
                    'url' => '/admin',
                ],
                [
                    'label' => 'Analytics',
                    'url' => '/analytics',
                ],
                [
                    'label' => 'Ads',
                    'url' => '/admin/ads',
                ],
            ],

            'advertiser' => [
                [
                    'label' => 'Dashboard',
                    'url' => '/advertiser',
                ],
                [
                    'label' => 'My Ads',
                    'url' => '/advertiser/ads',
                ],
                [
                    'label' => 'Create Ad',
                    'url' => '/advertiser/ads/create',
                ],
            ],

            'publisher' => [
                [
                    'label' => 'Dashboard',
                    'url' => '/publisher',
                ],
            ],
        ];
    }
}
