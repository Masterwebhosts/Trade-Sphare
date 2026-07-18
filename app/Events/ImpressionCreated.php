<?php

namespace App\Events;

use App\Models\Impression;

class ImpressionCreated
{
    public function __construct(
        public Impression $impression
    ) {}
}