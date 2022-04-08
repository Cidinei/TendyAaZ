<?php

namespace Modules\DeliveryRadiusPro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;

class DeliveryRadiusProController extends Controller
{

    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $restaurant
     * @param $delivery_radius
     * @return boolean
     */
    public static function checkRadiusDelivery($latitudeFrom, $longitudeFrom, $restaurant, $delivery_radius)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo   = deg2rad($restaurant->latitude);
        $lonTo   = deg2rad($restaurant->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * 6371; //distance in km

        if ($distance <= $delivery_radius) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $version = '2.9.1.1';
        return view('deliveryradiuspro::index', compact(['version']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('deliveryradiuspro::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('deliveryradiuspro::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('deliveryradiuspro::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
