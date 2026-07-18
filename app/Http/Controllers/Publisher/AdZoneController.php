<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdZone;
use App\Models\Governorate;
use App\Models\Ad;
use App\Models\Campaign;
use Illuminate\Support\Str;

class AdZoneController extends Controller
{

    public function index()
    {
        $zones = AdZone::where('publisher_id', auth()->id())
            ->withCount('ads')
            ->latest()
            ->get();

        return view(
            'publisher.zones.index',
            compact('zones')
        );
    }



    public function create()
    {
        $governorates = Governorate::orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | الإعلانات المتاحة للناشر
        |--------------------------------------------------------------------------
        | كل الإعلانات النشطة التابعة لحملات مقبولة
        |--------------------------------------------------------------------------
        */

        $ads = Ad::where(
                'status',
                Ad::STATUS_ACTIVE
            )
            ->whereHas('campaign', function ($q) {

                $q->where(
                    'status',
                    Campaign::STATUS_APPROVED
                );

            })
            ->latest()
            ->get();



        return view(
            'publisher.zones.create',
            compact(
                'governorates',
                'ads'
            )
        );
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


            'ads' => [
                'nullable',
                'array'
            ],


            'ads.*' => [
                'exists:ads,id'
            ],

        ]);



        $zone = AdZone::create([

            'publisher_id' => auth()->id(),

            'name' => $data['name'],

            'zone_type' => $data['zone_type'],

            'governorate_id' =>
                $data['governorate_id'] ?? null,

            'token' => Str::random(32),

            'status' => AdZone::STATUS_ACTIVE,

        ]);



        $zone->ads()->sync(
            $data['ads'] ?? []
        );



        return redirect()
            ->route('publisher.zones.index')
            ->with(
                'success',
                'تم إنشاء المنطقة الإعلانية بنجاح'
            );
    }





    public function edit($id)
    {

        $zone = AdZone::where(
            'publisher_id',
            auth()->id()
        )
        ->with('ads')
        ->findOrFail($id);



        $governorates = Governorate::orderBy('name')->get();



        $ads = Ad::where(
                'status',
                Ad::STATUS_ACTIVE
            )
            ->whereHas('campaign', function ($q) {

                $q->where(
                    'status',
                    Campaign::STATUS_APPROVED
                );

            })
            ->latest()
            ->get();



        return view(
            'publisher.zones.edit',
            compact(
                'zone',
                'governorates',
                'ads'
            )
        );
    }





    public function update(Request $request, $id)
    {

        $zone = AdZone::where(
            'publisher_id',
            auth()->id()
        )
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


            'governorate_id' => [
                'nullable',
                'exists:governorates,id'
            ],


            'ads' => [
                'nullable',
                'array'
            ],


            'ads.*' => [
                'exists:ads,id'
            ],

        ]);



        $zone->update([

            'name' => $data['name'],

            'zone_type' => $data['zone_type'],

            'governorate_id' =>
                $data['governorate_id'] ?? null,

        ]);



        $zone->ads()->sync(
            $data['ads'] ?? []
        );



        return redirect()
            ->route('publisher.zones.index')
            ->with(
                'success',
                'تم تحديث المنطقة بنجاح'
            );
    }





    public function destroy($id)
    {

        $zone = AdZone::where(
            'publisher_id',
            auth()->id()
        )
        ->findOrFail($id);



        $zone->ads()->detach();


        $zone->delete();



        return back()
            ->with(
                'success',
                'تم حذف المنطقة'
            );
    }

}