<?php

namespace App\Observers;

use App\Models\Click;
use App\Events\ClickCreated;

class ClickObserver
{
    public function created(Click $click): void
    {
        event(new ClickCreated($click));
    }
}