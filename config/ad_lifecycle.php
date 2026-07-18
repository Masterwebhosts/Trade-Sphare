<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ad Lifecycle Engine States
    |--------------------------------------------------------------------------
    | هذا الملف هو المصدر الوحيد لحالات الإعلان في النظام
    | يمنع التشتت بين status / deleted / flags
    */

    'states' => [

        'draft'          => 'draft',
        'pending_review' => 'pending_review',
        'active'         => 'active',
        'paused'         => 'paused',
        'rejected'       => 'rejected',
        'deleted'        => 'deleted',

    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed transitions (مهم لاحقاً)
    |--------------------------------------------------------------------------
    */

    'transitions' => [

        'draft' => ['pending_review'],

        'pending_review' => ['active', 'rejected'],

        'active' => ['paused', 'deleted'],

        'paused' => ['active', 'deleted'],

        'rejected' => [],

        'deleted' => [],

    ],

];