<?php

namespace Modules\Cashback\Http\Controllers;

use App\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cashback\Entities\CashbackReport;
use Modules\Cashback\Entities\CashBackSetting;

class CashbackController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('cashback::index');
    }

    /**
     * @param $restaurant_id
     * @param $range
     * @return array
     */
    private function getSearch($restaurant_id, $range)
    {
        $cashbackReport = [];

        if(isset($restaurant_id) && !empty($restaurant_id) || isset($range) && !empty($range)) {
            // Range 1 = This Week
            if ($range == '1') {
                $cashbackReport = CashbackReport::where('restaurant_id', $restaurant_id)
                    ->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek(),
                    ])->paginate();
            }

            // Range 2 = Last 7 Days
            if ($range == '2') {
                $cashbackReport = CashbackReport::where('restaurant_id', $restaurant_id)
                    ->whereDate('created_at', '>', Carbon::now()->subDays(7))
                    ->paginate();
            }

            // Range 3 = This Month
            if ($range == '3') {
                $cashbackReport = CashbackReport::where('restaurant_id', $restaurant_id)
                    ->whereBetween('created_at', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth(),
                    ])->paginate();
            }

            // Range 4 = Last 30 Days
            if ($range == '4') {
                $cashbackReport = CashbackReport::where('restaurant_id', $restaurant_id)
                    ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                    ->paginate();
            }

            // Range 5 = All time
            if ($range == '5') {
                $cashbackReport = CashbackReport::where('restaurant_id', $restaurant_id)
                    ->paginate();
            }

            // Range null = From the begining of time
            if ($range == null) {
                $cashbackReport = CashbackReport::where('restaurant_id', $restaurant_id)
                    ->paginate();
            }
        }else{
            $cashbackReport = CashbackReport::paginate();
        }

        return $cashbackReport;
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function settings(Request $request)
    {
        $setting = CashBackSetting::first();
        return view('cashback::settings', compact(['setting']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminReports(Request $request)
    {
        // Search
        $range          = null;
        $range          = $request->range ?? null;
        $restaurant_id  = $request->restaurant_id ?? null;
        $cashbackReport = $this->getSearch($restaurant_id, $range);

        // Restaurants
        $restaurants = [];

        if (auth()->user()->hasRole('Store Owner')) {
            $restaurants = auth()->user()->restaurants; // Pega todos os restaurantes
        }else{
            $restaurants = Restaurant::all(); // Pega todos os restaurantes
        }

        return view('cashback::reportsadmin', compact(['cashbackReport', 'restaurants']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function reports(Request $request)
    {
        // Search
        $range          = null;
        $range          = $request->range ?? null;
        $restaurant_id  = $request->restaurant_id ?? null;
        $cashbackReport = $this->getSearch($restaurant_id, $range);

        // Restaurants
        $restaurants = auth()->user()->restaurants; // Pega todos os restaurantes

        return view('cashback::reports', compact(['cashbackReport', 'restaurants']));
    }

    /**
     * Store
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $setting = CashBackSetting::first();
        if(!empty($setting)) {
            $data = [
                'restaurant_edit'  => (isset($request->restaurant_edit) && $request->restaurant_edit == "true" ? 1 : 0),
                'sum_total_amount' => (isset($request->sum_total_amount) && $request->sum_total_amount == "true" ? 1 : 0),
            ];

            if($setting->update($data)) {
                return back()->with('success', \Lang::get('cashback::default.Saved successfully'));
            }
        }

        return back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('cashback::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('cashback::edit');
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
