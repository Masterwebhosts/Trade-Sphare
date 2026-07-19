<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\View\View;

class AdPreviewController extends Controller
{
    public function show(Ad $ad): View
    {
        return view('ads.show', compact('ad'));
    }
}
