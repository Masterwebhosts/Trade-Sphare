<?php

namespace App\Http\Controllers;

use App\Models\AdZone;
use App\Services\AdSelectionService;
use App\Services\Tracking\ImpressionService;
use Illuminate\Http\Request;

class ZoneLandingController extends Controller
{
    public function __construct(
        protected AdSelectionService $adSelection,
        protected ImpressionService $impressionService
    ) {}



    public function show(Request $request, $zoneId)
    {
        $zone = AdZone::findOrFail($zoneId);



        if (! $zone->isServeable()) {

            abort(404);

        }



        $ad = $this->adSelection->serve(

            $zone->id,

            $zone->publisher_id,

            $request->ip()

        );



        if ($ad) {

            $this->impressionService->record(

                $ad,

                $request,

                [
                    'zone' => $zone,
                    'channel' => 'landing',
                ]

            );

        }



        return view(
            'ads.link-zone',
            compact(
                'zone',
                'ad'
            )
        );
    }
}