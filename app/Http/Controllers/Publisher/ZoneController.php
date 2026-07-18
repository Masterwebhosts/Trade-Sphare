<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AdZone;
use App\Models\Governorate;
use App\Services\AdService;
use App\Services\Tracking\ImpressionService;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = AdZone::where('publisher_id', auth()->id())
            ->latest()
            ->get();

        return view('publisher.zones.index', compact('zones'));
    }


    public function create()
    {
        $governorates = Governorate::orderBy('name')->get();

        return view('publisher.zones.create', compact('governorates'));
    }



    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'zone_type' => [
                'required',
                'in:banner,native,popup'
            ],

            'governorate_id' => [
                'nullable',
                'exists:governorates,id'
            ],

        ]);



        AdZone::create([

            'publisher_id' => auth()->id(),

            'name' => $data['name'],

            'zone_type' => $data['zone_type'],

            'governorate_id' =>
                $data['governorate_id'] ?? null,

            'token' => Str::random(32),

            'status' => 'active',

        ]);



        return redirect()
            ->route('publisher.zones.index')
            ->with(
                'success',
                'تم إنشاء منطقة الإعلان بنجاح'
            );
    }





    public function edit($id)
    {
        $zone = AdZone::where('publisher_id', auth()->id())
            ->findOrFail($id);

        return view(
            'publisher.zones.edit',
            compact('zone')
        );
    }





    public function update(Request $request, $id)
    {
        $zone = AdZone::where('publisher_id', auth()->id())
            ->findOrFail($id);



        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'zone_type' => [
                'required',
                'in:banner,native,popup'
            ],

        ]);



        $zone->update([

            'name' => $data['name'],

            'zone_type' => $data['zone_type'],

        ]);



        return redirect()
            ->route('publisher.zones.index')
            ->with(
                'success',
                'تم تحديث منطقة الإعلان بنجاح'
            );
    }





    public function destroy($id)
    {
        $zone = AdZone::where('publisher_id', auth()->id())
            ->findOrFail($id);


        $zone->delete();


        return redirect()
            ->route('publisher.zones.index')
            ->with(
                'success',
                'تم حذف منطقة الإعلان بنجاح'
            );
    }





    public function analytics($id)
    {
        $zone = AdZone::where('publisher_id', auth()->id())
            ->findOrFail($id);


        return view(
            'publisher.zones.analytics',
            compact('zone')
        );
    }





    public function view($id, AdService $adService)
    {
        $zone = AdZone::where('publisher_id', auth()->id())
            ->findOrFail($id);


        $ad = $adService->getAdForZone($zone->id);



        return view(
            'publisher.zones.view',
            compact('ad', 'zone')
        );
    }





    public function embed(
        $id,
        AdService $adService,
        ImpressionService $impressionService
    ) {

        $zone = AdZone::findOrFail($id);



        if (!$zone->isServeable()) {
            abort(404);
        }



        $ad = $adService->getAdForZone($zone->id);



        if ($ad) {

            $impressionService->registerImpression($ad, [

                'zone_id' => $zone->id,

                'publisher_id' => $zone->publisher_id,

            ]);

        }



        return view(
            'ads.embed',
            compact('ad', 'zone')
        );
    }





    public function serve($id, AdService $adService)
    {
        $zone = AdZone::findOrFail($id);



        if (!$zone->isServeable()) {

            return response()->json([

                'success' => false,

                'data' => null,

            ]);

        }



        $ad = $adService->getAdForZone($zone->id);



        return response()->json([

            'success' => (bool) $ad,

            'data' => $ad,

        ]);
    }
}