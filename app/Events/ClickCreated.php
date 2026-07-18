<?php

namespace App\Events;

use App\Models\Click;

class ClickCreated
{
    public function __construct(
        public Click $click
    ) {}
}