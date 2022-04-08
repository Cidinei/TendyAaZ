<?php

namespace Modules\ThermalPrinterPro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;

class ThermalPrinterProController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $version = '2.9.1.1';
        return view('thermalprinterpro::index', compact(['version']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('thermalprinterpro::create');
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
        return view('thermalprinterpro::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('thermalprinterpro::edit');
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


    public function printOrder($order_id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = \App\Order::whereIn('restaurant_id', $restaurantIds)
            ->where('unique_order_id', $order_id)
            ->first();

        if ($order) {
            return view('restaurantowner.printOrder', array(
                'order' => $order,
            ));
        } else {
            return redirect()->route('restaurantowner.orders');
        }
    } 
}
