<?php

namespace Modules\StoreDashBoardPro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;

class StoreDashBoardProController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $version = '2.8.2.1';
        return view('storedashboardpro::index', compact(['version']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('storedashboardpro::create');
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
        return view('storedashboardpro::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('storedashboardpro::edit');
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

    public function markOrderSend($id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = \App\Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '2' || $order->orderstatus_id == '3') {
            $order->orderstatus_id = 4;
            $order->save();

            if (config('settings.enablePushNotificationOrders') == 'true') {
                //to user
                $notify = new \App\PushNotify();
                $notify->sendPushNotification('4', $order->user_id, $order->unique_order_id);
            }

            return redirect()->back()->with(array('success' => 'Pedido marcado como Enviado'));
        } else {
            return redirect()->back()->with(array('message' => 'Something went wrong.'));
        }
    }
}
