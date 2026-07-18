<?php

return [

    'admin' => [

        [
            'label' => 'الرئيسية',
            'route' => 'admin.dashboard',
        ],

        [
            'label' => 'المستخدمون',
            'route' => 'admin.users.index',
        ],

        [
            'label' => 'الحملات',
            'route' => 'admin.campaigns.index',
        ],

        [
            'label' => 'الإعلانات',
            'route' => 'admin.ads.index',
        ],

        [
            'label' => 'الشحن',
            'route' => 'admin.topups.index',
        ],

        [
            'label' => 'السحوبات',
            'route' => 'admin.withdrawals.index',
        ],

         [
            'label' =>'  طلبات الشحن ',
            'route' => 'admin.topups.index',
        ],

        [
            'label' => 'المالية',
            'route' => 'admin.finance.index',
        ],

        [
        'label' => 'التحليلات',
        'route' => 'admin.analytics.index',
        ],

        [
           'label' => 'تحليل الاحتيال',
           'route' => 'admin.fraud.dashboard',
        ],

    ],

    'advertiser' => [

        [
            'label' => 'لوحة التحكم',
            'route' => 'advertiser.dashboard',
        ],

        [
            'label' => 'الحملات الإعلانية',
            'route' => 'advertiser.campaigns.index',
        ],

        [
            'label' => 'إنشاء حملة',
            'route' => 'advertiser.campaigns.create',
        ],

        [
            'label' => 'الإعلانات',
            'route' => 'advertiser.ads.index',
        ],

        [
            'label' => 'إنشاء إعلان',
            'route' => 'advertiser.ads.create',
        ],

        [
            'label' => 'الإحصائيات',
            'route' => 'advertiser.stats.index',
        ],

        [
            'label' => 'المحفظة / شحن الرصيد',
            'route' => 'advertiser.topup.create',
        ],

                [
            'label' => 'مركز المساعدة',
            'route' => 'pages.info',
        ],

    ],

    'publisher' => [

        [
            'label' => 'الرئيسية',
            'route' => 'publisher.dashboard',
        ],

        [
            'label' => 'مناطق الإعلانات',
            'route' => 'publisher.zones.index',
        ],

        [
            'label' => 'الأرباح',
            'route' => 'publisher.earnings.index',
        ],

        [
            'label' => 'المحفظة',
            'route' => 'publisher.wallet.index',
        ],

        [
            'label' => 'السحوبات',
            'route' => 'publisher.withdrawals.index',
        ],

                [
            'label' => 'مركز المساعدة',
            'route' => 'pages.info',
        ],

    ],

];