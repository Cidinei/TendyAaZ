<?php

namespace App\Http\Controllers;

use App\AcceptDelivery;
use App\DeliveryGuyDetail;
use App\Helpers\TranslationHelper;
use App\Http\Middleware\SCLC;
use App\Http\Middleware\SCLCC;
use App\Http\Middleware\SelfHelpM;
use Auth;
use App\Item;
use App\ItemCategory;
use App\Order;
use App\Orderitem;
use App\OrderItemAddon;
use App\Orderstatus;
use App\PaymentGateway;
use App\Restaurant;
use App\RestaurantEarning;
use App\RestaurantCategory;
use App\RestaurantPayout;
use App\Setting;
use App\User;
use Bavix\Wallet\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Ixudra\Curl\Facades\Curl;
use Spatie\Permission\Models\Role;
use App\Exports\DeliverReportExport;
use App\Exports\StoreWiseReportExport;
use App\Exports\UserReportExport;
use App\Exports\customerPerformanceExport;
use App\Exports\storePerformanceExport;
use Maatwebsite\Excel\Facades\Excel;

class NewReportController extends Controller
{
    public function storePerformaceReport(Request $request)
    {                
    	//eleqoent query
        $userType = '';        
        $search_data['start_date'] = @$request->report_start_date;
        $search_data['end_date'] = @$request->report_end_date;

        if(\Route::current()->getName() === "admin.storeperformance"){

            $userType = 'admin';

            $restaurantData = Restaurant::where('is_accepted','1')->with('orders');        

            $displayRestaurants = $restaurantData->count();

            //$restaurants = Restaurant::where('is_accepted','1')->with('orders')->paginate(50);                        

            $orderData = Order::where('orderstatus_id', 5);

        } else {         

            $userType = 'owner';   

            $ownerRestaurant = $this->getAuthResId();

            $restaurantData = Restaurant::whereIn('id',$ownerRestaurant)->where('is_accepted','1')->with('orders');            

            $displayRestaurants = $restaurantData->count();
        
            $orderData = Order::whereIn('restaurant_id',$ownerRestaurant)->where('orderstatus_id', 5);            
        }    

        if(!empty($request->report_start_date) && !empty($request->report_end_date)){
            $fromDate = Carbon::parse($request->report_start_date);            
            $toDate = Carbon::parse($request->report_end_date);
            $toDate->addDays(1);           
            $orderData = $orderData->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());            

            $restaurantData = Restaurant::where('is_accepted','1')->with(['orders' => function($query) use ($fromDate,$toDate){
                $query->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());   
            }]);

            if(\Route::current()->getName() !== "admin.storeperformance"){
                $restaurantData = $restaurantData->whereIn('id',$ownerRestaurant);
            }
        }

            $restaurants = $restaurantData->paginate(50);

            $totalEarn = $orderData->sum('total');
            $deliveryCharges = $orderData->sum('delivery_charge');
			$tipAmount = $orderData->sum('tip_amount');
			$displayEarnings = ($totalEarn - ( $deliveryCharges + $tipAmount ));            
            
            $displaySales = $orderData->count();
        
            foreach ($restaurants as $restaurant) {
                $completedCount = 0;
                $cancelledCount = 0;
                $totalAmountData = 0;
                $totalEarningData = 0;
                $deliveryTime = 0;

                foreach ($restaurant->orders as $key => $order) {
                    if($order->orderstatus_id == "5")
                    {
                        $completedCount++;
                        //$totalAmountData += $order->total;                        
                        $totalAmountData += ($order->total - ($order->delivery_charge + $order->tip_amount));
                        //$totalEarningData += $order->total - ($order->total * $restaurant->commission_rate/100);
                        $totalEarningData += (($order->total - ($order->delivery_charge + $order->tip_amount)) - (($order->total - ($order->delivery_charge + $order->tip_amount))*$restaurant->commission_rate/100));
                        $deliveryTime += ($order->updated_at->diffInMinutes($order->created_at));
                    }
                    if($order->orderstatus_id == "6")
                    {
                        $cancelledCount++;
                    }
                }
            
            $totalCount = count($restaurant->orders);
            $restaurant->completedCount = $completedCount;
            $restaurant->cancelledCount = $cancelledCount;
            $restaurant->totalCount = $totalCount;
            $restaurant->totalAmountData = $totalAmountData;        
            $restaurant->totalEarningData = $totalEarningData;
            $restaurant->adminEarning = ($totalAmountData - $totalEarningData);

            if($completedCount !== 0){
                $restaurant->deliveryTime = number_format(($deliveryTime / $completedCount),2);    
            }else{
                $restaurant->deliveryTime = ($deliveryTime);
            }            
          }

    return view('admin.newreports.storeperformance', array (
        'restaurants' => $restaurants,            
        'search_data' => $search_data,
        'displayRestaurants' => $displayRestaurants,
        'displaySales' => $displaySales,
        'displayEarnings' => $displayEarnings,
        'user_type' => $userType
        ));
}

public function storeWiseOrderReport(Request $request)
{        
    $userType = '';
    $search_data['restaurant_id'] = @$request->restaurant_id;
    $search_data['start_date'] = @$request->report_start_date;
    $search_data['end_date'] = @$request->report_end_date;
    $search_data['payment_mode'] = @$request->payment_mode;
    $search_data['delivery_type'] = @$request->delivery_type;

    if(\Route::current()->getName() === "admin.storeWiseOrderReport"){
        $userType = 'admin';
        $allRestaurants = Restaurant::get();
        $orders = Order::where('orderstatus_id','5')->latest();                   
        $restaurant_id = Restaurant::where('id')->get();
        $restaurant = Restaurant::where('is_accepted', '1')->get();
        $total = Order::where('payable')->get();    
    }else{
        $userType = 'owner';
        $ownerRestaurant = $this->getAuthResId();
        $allRestaurants = Restaurant::whereIn('id',$ownerRestaurant)->get();
        $orders = Order::whereIn('restaurant_id',$ownerRestaurant)->where('orderstatus_id','5')->latest();                   
        $restaurant_id = Restaurant::whereIn('id',$ownerRestaurant)->where('id')->get();
        $restaurant = Restaurant::whereIn('id',$ownerRestaurant)->where('is_accepted', '1')->get();
        $total = Order::whereIn('restaurant_id',$ownerRestaurant)->where('payable')->get();            
    }        
        /////////////// For Restaurants Based Search/////////////////
    if (!empty($request->restaurant_id)) {
        $orders = $orders->where('restaurant_id', $request->restaurant_id);                      
    }

    if(!empty($request->report_start_date) && !empty($request->report_end_date)){
        $fromDate = Carbon::parse($request->report_start_date);            
        $toDate = Carbon::parse($request->report_end_date);
        $toDate->addDays(1);           
        $orders = $orders->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());
    }

    if (!empty($request->payment_mode)) {        
        $orders = $orders->where('payment_mode',$request->payment_mode);
    }
    if (!empty($request->delivery_type)) {        
        $orders = $orders->where('delivery_type',$request->delivery_type);
    }

    $orders = $orders->with('restaurant')->paginate(50);

    return view('admin.newreports.storeWiseOrderReport', array(
       'orders' => $orders,
       'restaurants' => $allRestaurants,        
       'search_data' => $search_data,
       'restaurant_id' => $restaurant_id,     
       'user_type' => $userType
       ));
}
    /**
     * @param Request $request
     */
    public function postSearchOrdersPayment(Request $request)
    {
        $query = $request['query'];

        $orders = Order::where('payment_mode', 'LIKE', '%' . $query . '%')->orderBy('id','DESC')->with('accept_delivery.user', 'restaurant')->paginate(250);

        $count = $orders->total();

        return view('admin.orders', array(
            'orders' => $orders,
            'count' => $count,
            ));
    }
    public function deliveryEarningsReport(Request $request)
    {           
        $search_data['start_date'] = @$request->report_start_date;
        $search_data['end_date'] = @$request->report_end_date;
        $search_data['deliver_by_id'] = @$request->deliver_by_id;            

        $delivery_details = User::whereNotNull('delivery_guy_detail_id')->get();
        $settings = Setting::get();

        /////////////// For delivery boy Based Search and date wise search/////////////////

        if (!empty($request->deliver_by_id)) {
            $orders = Order::with('accept_delivery.user','restaurant')->whereHas('accept_delivery', function ($query) use ($search_data) {
              $query->where('user_id',$search_data['deliver_by_id']);
          })->where(['orderstatus_id'=>'5','delivery_type'=>'1'])->latest();
        }else{
            $orders = Order::with('accept_delivery.user','restaurant')->where(['orderstatus_id'=>'5','delivery_type'=>'1'])->latest();
        }

        if(!empty($request->report_start_date) && !empty($request->report_end_date)){
            $fromDate = Carbon::parse($request->report_start_date);            
            $toDate = Carbon::parse($request->report_end_date);
            $toDate->addDays(1);                        
            $orders = $orders->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());
        }
        
        $orders = $orders->paginate(50);

        return view('admin.newreports.deliveryEarningsReport', array(            
            'orders' => $orders,
            'delivery_details' => $delivery_details,
            'settings' => $settings,
            'search_data' => $search_data,
            ));
    }

    public function orderWiseTaxReport(Request $request)
    {
        $search_data['start_date'] = @$request->report_start_date;
        $search_data['end_date'] = @$request->report_end_date;
        
        $orders = Order::where('orderstatus_id','5')->latest();
        if(!empty($request->report_start_date) && !empty($request->report_end_date)){
            $fromDate = Carbon::parse($request->report_start_date);            
            $toDate = Carbon::parse($request->report_end_date);
            $toDate->addDays(1);           
            $orders = $orders->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());
        }

        $orders = $orders->with('restaurant')->paginate(50);

        return view('admin.newreports.orderWiseTaxReport', array(            
            'orders' => $orders,
            'search_data' => $search_data,
            ));
    }

    public function exportReport(Request $request,$report)
    {                
        if ($report === "delivery_details"){
            return Excel::download(new DeliverReportExport, 'delivery_report.xlsx');        
        }elseif ($report === "store_wise"){
            return Excel::download(new StoreWiseReportExport, 'store_wise_report.xlsx');        
        }elseif ($report === "users"){
            return Excel::download(new UserReportExport, 'users_report.xlsx');        
        }elseif ($report === "customer_performance"){
            return Excel::download (new customerPerformanceExport, 'customer_performance_report.xlsx');
        }elseif ($report === "store_performance"){
            return Excel::download (new storePerformanceExport, 'store_performance_report.xlsx');
        }
    }

    public function getAuthResId(){
        $user = Auth::user();
        $restaurants = $user->restaurants;
        $ownerRestaurant = $restaurants->pluck('id');
        return $ownerRestaurant;
    }
    
    public function storeBalanceReport(Request $Request){
        $restaurants = Restaurant::paginate(50);
        
        return view('admin.newreports.storeBalanceReport',array(
            'restaurants' => $restaurants)
            );
    }
    
    public function customerPerformanceReport (Request $Request) {
        $users = User::with('orders')->where('is_active', '1')->paginate(50);

        foreach($users as $user) {
            $orderIds = [];
            foreach($user->orders as $order) {
                $orderIds[] = $order->id;
            }

            $itemIds = [];
            $itemQuantities = [];

            $orderItems = Orderitem::whereIn('order_id', $orderIds)->get();
            foreach($orderItems as $orderItem) {
                $itemIds[] = $orderItem->item_id;

                if(isset($itemQuantities[$orderItem->item_id])) {
                    $itemQuantities[$orderItem->item_id] = $itemQuantities[$orderItem->item_id] + $orderItem->quantity;
                } else {
                    $itemQuantities[$orderItem->item_id] = $orderItem->quantity;
                }
            }

            $itemCountMap = [];
            for($i = 0; $i < count($itemIds); $i += 1) { 
                $itemId = $itemIds[$i];
                if(isset($itemCountMap[$itemId])) {
                    $itemCountMap[$itemId] = $itemCountMap[$itemId] + 1;
                } else {
                    $itemCountMap[$itemId] = 1;
                }
            }

            if(count($itemCountMap)) {
                arsort($itemCountMap);
                $favItemId = array_keys($itemCountMap)[0];
                $favItem = Item::where('id', $favItemId)->select(['id', 'name', 'restaurant_id'])->first();

                if($favItem) {
                    $user->favItem = $favItem;
                    $user->favItemText = $favItem->id . ' - ' . $favItem->name . ' x' . $user->favItemQuantity;
                    $user->favItemQuantity = $itemQuantities[$favItem->id];

                    $favRestaurant = Restaurant::where('id', $favItem->restaurant_id)->select(['id', 'name'])->first();
                    if($favRestaurant) {
                        $user->favRestaurant = $favRestaurant;
                        $user->favRestaurantText = $favRestaurant->id . ' - ' . $favRestaurant->name;
                    }
                } else {
                    $user->favItemText = '';
                    $user->favRestaurantText = '';
                }
            }
        }
        
        $orderData = Order::where('orderstatus_id', '5');
        $search_data['start_date'] = @$request->report_start_date;
        $search_data['end_date'] = @$request->report_end_date;

        if(!empty($request->report_start_date) && !empty($request->report_end_date)){
            $fromDate = Carbon::parse($request->report_start_date);            
            $toDate = Carbon::parse($request->report_end_date);
            $toDate->addDays(1);           
            $orderData = $orderData->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());            

            $Users = $users->with(['orders' => function($query) use ($fromDate,$toDate){
                $query->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());
            }]);
        }
        
        $displayUsers = $users->count();
		$deliveryCharges = $orderData->sum('delivery_charge');
		$tipAmount = $orderData->sum('tip_amount');
		$totalEarn = $orderData->sum('total');
		$displayEarnings = ($totalEarn - ( $deliveryCharges + $tipAmount ));
		$displaySales = $orderData->count();
        
        return view('admin.newreports.customerPerformance', [
        	'users' => $users,
            'search_data' => $search_data,
        	'orderData' => $orderData,
        	'displaySales' => $displaySales,
        	'displayEarnings' => $displayEarnings,
        	'displayUsers' => $displayUsers
        ]);
    }
    
    public function deliveryGuyBalanceReport (Request $Request) {
        $delivery_details = User::whereNotNull('delivery_guy_detail_id')->with('delivery_guy_details')->paginate(50);
        
        return view ('admin.newreports.deliveryGuyBalanceReport', array(
        'delivery_details' => $delivery_details)
        );
    }
    
    public function topRestaurantItems (Request $request) {
        
        $todaysDate = Carbon::now()->format('d-m-Y');
        $range = null;
        $range = $request->range;

        $ownerRestaurant = $this->getAuthResId();
        $restaurants = Restaurant::whereIn('id',$ownerRestaurant)->where('is_accepted','1')->get();

        $restaurant_id = null;
        $restaurant = null;
        $top_items_total = null;
        $top_item_addons_total = null;
        $top_items_data = null;
        $top_item_addons = null;

        $restaurant_id = $request->restaurant_id;

        // dd($restaurant_id);

        //////////////////////////////////////////////////////////////
        /////////////// For Restaurants Based Search/////////////////
        /////////////////////////////////////////////////////////////

        $top_items_completed_restaurant = null;
        $top_items_restaurant = null;

        // dd($restaurant);
        if ($restaurant_id) {

            $restaurant = Restaurant::whereIn('id',$ownerRestaurant)->where('is_accepted','1')->with('orders');

            // Range 1 = This Week
            if ($range == '1') {
                $top_items_orders_completed = Order::where('orderstatus_id', '5')->where('restaurant_id', $restaurant_id)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ])->pluck('id');
            }
            // Range 2 = Last 7 Days
            if ($range == '2') {
                $top_items_orders_completed = Order::where('orderstatus_id', '5')->where('restaurant_id', $restaurant_id)->whereDate('created_at', '>', Carbon::now()->subDays(7))->pluck('id');
            }
            // Range 3 = This Month
            if ($range == '3') {
                $top_items_orders_completed = Order::where('orderstatus_id', '5')->where('restaurant_id', $restaurant_id)->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])->pluck('id');
            }
            // Range 4 = Last 30 Days
            if ($range == '4') {
                $top_items_orders_completed = Order::where('orderstatus_id', '5')->where('restaurant_id', $restaurant_id)->whereDate('created_at', '>', Carbon::now()->subDays(30))->pluck('id');
            }
            // Range 5 = All time
            if ($range == '5') {
                $top_items_orders_completed = Order::where('orderstatus_id', '5')->where('restaurant_id', $restaurant_id)->pluck('id');
            }
            // Range null = From the begining of time
            if ($range == null) {
                $top_items_orders_completed = Order::where('orderstatus_id', '5')->where('restaurant_id', $restaurant_id)->pluck('id');
            }

            $anyOrder = $top_items_orders_completed->count();
            //dd($anyOrder);

            $top_items_completed_restaurant = Orderitem::whereIn('order_id', $top_items_orders_completed)->select('item_id', 'name', 'price', DB::raw('SUM(quantity) as qty'))->groupBy('item_id')->orderBy('qty', 'DESC')->take(10)->get();

            $top_items_restaurant = '[';
            foreach ($top_items_completed_restaurant as $item) {

                $top_items_restaurant .= '{value:' . $item->qty . ", name: '" . $item->name . "'},";

            }
            $top_items_restaurant = rtrim($top_items_restaurant, ',');
            $top_items_restaurant .= ']';
        }

        // For Top  Total Items Sold
        if (!$restaurant_id) {
            // Range 1 = This Week
            if ($range == '1') {
                $top_items_completed = Order::where('orderstatus_id', '5')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ])->pluck('id');
            }
            // Range 2 = Last 7 Days
            if ($range == '2') {
                $top_items_completed = Order::where('orderstatus_id', '5')->whereDate('created_at', '>', Carbon::now()->subDays(7))->pluck('id');
            }
            // Range 3 = This Month
            if ($range == '3') {
                $top_items_completed = Order::where('orderstatus_id', '5')->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])->pluck('id');
            }
            // Range 4 = Last 30 Days
            if ($range == '4') {
                $top_items_completed = Order::where('orderstatus_id', '5')->whereDate('created_at', '>', Carbon::now()->subDays(30))->pluck('id');
            }
            // Range 5 = All time
            if ($range == '5') {
                $top_items_completed = Order::where('orderstatus_id', '5')->pluck('id');
            }
            // Range null = From the begining of time
            if ($range == null) {
                $top_items_completed = Order::where('orderstatus_id', '5')->pluck('id');
            }
            $anyOrder = $top_items_completed->count();
            $top_items_total = Orderitem::whereIn('order_id', $top_items_completed)->select('order_id', 'item_id', 'name', 'price', DB::raw('SUM(quantity) as qty'))->groupBy('item_id')->orderBy('qty', 'DESC')->take(10)->get();
            
            //dd($top_items_total);
            // For Charts
            $top_items_data = null;
            $top_items_data = '[';
            
            foreach ($top_items_total as $item1) {
                $top_items_data .= '{value:' . $item1->qty . ", name: '" . $item1->name . "'},";
            }
            
            $top_items_data = rtrim($top_items_data, ',');
            $top_items_data .= ']';
            
            $top_item_addons_total = OrderItemAddon::whereIn('orderitem_id', $top_items_completed)->select('id', 'orderitem_id', 'addon_name', 'addon_price')->take(10)->get();
            $top_item_addons = null;
            $top_item_addons = '[';
            
            foreach ($top_item_addons_total as $item1) {
                $top_item_addons .= '{value:' . $item1->addon_price . ", name: '" . $item1->addon_name . "'},";
            }
            
            $top_item_addons = rtrim($top_item_addons, ',');
            $top_item_addons .= ']';
        }

        return view('restaurantowner.newreports.viewTopItems', array(
            'range' => $range,
            'todaysDate' => $todaysDate,
            'restaurants' => $restaurants,
            'top_items_restaurant' => $top_items_restaurant,
            'top_item_addons' => \json_decode($top_item_addons),
            'top_items_completed_restaurant' => $top_items_completed_restaurant,
            'restaurant' => $restaurant,
            'top_items_total' => $top_items_total,
            'top_item_addons_total' => $top_item_addons_total,
            'top_items_data' => $top_items_data,
            'anyOrder' => $anyOrder,
        ));
    }

    public function paymentReports (Request $request) {
        $search_data['start_date'] = @$request->report_start_date;
        $search_data['end_date'] = @$request->report_end_date;
        $search_data['payment_mode'] = @$request->payment_mode;
    
        $orders = Order::where('orderstatus_id', '5')->where('payment_mode', 'LIKE', '%')->orderBy('id','desc')->paginate(50);
        $restaurants = Restaurant::where('is_accepted', '1')->get();

        if (!empty($request->restaurant_id)) {
            $orders = $orders->where('restaurant_id', $request->restaurant_id);                      
        }
        if(!empty($request->report_start_date) && !empty($request->report_end_date)){
            $fromDate = Carbon::parse($request->report_start_date);            
            $toDate = Carbon::parse($request->report_end_date);
            $toDate->addDays(1);           
            $orders = $orders->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());
        }
        
        if (!empty($request->payment_mode)) {        
            $orders = $orders->where('payment_mode',$request->payment_mode);
        }

        return view('admin.newreports.paymentReport', [
            'orders' => $orders,
            'search_data' => $search_data,
            'restaurants' => $restaurants,
        ]);
    }

    public function adminEarningsReport(Request $request) {
        $userType ='';
        $search_data['restaurant_id'] = @$request->restaurant_id;
        $search_data['start_date'] = @$request->report_start_date;
        $search_data['end_date'] = @$request->report_end_date;
        $search_data['payment_mode'] = @$request->payment_mode;
        $search_data['delivery_type'] = @$request->delivery_type;

        $allRestaurants = Restaurant::get();
        $orders = Order::where('orderstatus_id','5')->latest();                   
        $restaurant_id = Restaurant::where('id')->get();
        $restaurant = Restaurant::where('is_accepted', '1')->get();
        $total = Order::where('payable')->get();

            /////////////// For Restaurants Based Search/////////////////
        if (!empty($request->restaurant_id)) {
            $orders = $orders->where('restaurant_id', $request->restaurant_id);                      
        }

        if(!empty($request->report_start_date) && !empty($request->report_end_date)){
            $fromDate = Carbon::parse($request->report_start_date);            
            $toDate = Carbon::parse($request->report_end_date);
            $toDate->addDays(1);           
            $orders = $orders->where('created_at', '>=', $fromDate->toDateString())->where('created_at', '<=', $toDate->toDateString());
        }

        if (!empty($request->payment_mode)) {        
            $orders = $orders->where('payment_mode',$request->payment_mode);
        }
        if (!empty($request->delivery_type)) {        
            $orders = $orders->where('delivery_type',$request->delivery_type);
        }

        $orders = $orders->with('restaurant')->paginate(50);

        return view('admin.newreports.adminEarningsReport', array(
        'orders' => $orders,
        'restaurants' => $allRestaurants,        
        'search_data' => $search_data,
        'restaurant_id' => $restaurant_id,     
        'user_type' => $userType
        ));
    }
}