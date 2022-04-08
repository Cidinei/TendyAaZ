<?php

namespace App\Console;

use App\PushNotify;
use App\Restaurant;
use App\Sms;
use Cache;
use Carbon\Carbon;
use DotenvEditor;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Facades\Module;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        if (Schema::hasTable('restaurants')) {

            // $schedule->command('inspire')->hourly();

            // Fetches today's week name and converts it into lowercase
            $day = strtolower(Carbon::now()->timezone(config('app.timezone'))->format('l'));

            // Gets All Restaurants
            $restaurants = Restaurant::with(['orders' => function ($q) {
                $q->whereIn('orders.orderstatus_id', ['10', '11']); //get scheduled orders...
            }])->get();

            $minsSetByAdmin = (int) config('appSettings.minsBeforeScheduleOrderProcessed'); //get this from module settings "minsBeforeScheduleOrderProcessed"

            $now = Carbon::now()->timezone(config('app.timezone'));

            // Loop All Restaurants with and for each restaurants variable as $restaurant
            foreach ($restaurants as $restaurant) {

                if ($restaurant->is_schedulable) {
                    // Get Timing Data From Database
                    $schedule_data = $restaurant->schedule_data;
                    // Json Decode The data
                    $schedule_data = json_decode($schedule_data);

                    // Checks if the restaurant has Schedule_data
                    if ($schedule_data) {

                        if (isset($schedule_data->$day)) {

                            // Checks if it has more than 0 data
                            if (count($schedule_data->$day) > 0) {
                                $is_active = false;

                                // Loops Data into Time Slots
                                foreach ($schedule_data->$day as $time) {
                                    if (!$is_active) {
                                        // Checks for Time Slots, Where  Current Time is In between those Slots If true its open
                                        if (Carbon::parse($time->open) < $now && Carbon::parse($time->close) > $now) {
                                            $is_active = true;
                                        }
                                    }
                                }
                                // dd($is_active);
                                $restaurant->is_active = $is_active;
                                $restaurant->save();

                                Cache::forget('store-info-' . $restaurant->slug);
                                Cache::forget('stores-delivery-active');
                                Cache::forget('stores-delivery-inactive');
                                Cache::forget('stores-selfpickup-active');
                                Cache::forget('stores-selfpickup-inactive');
                            }
                        }
                    }
                }

                if (Module::find('OrderSchedule') && Module::find('OrderSchedule')->isEnabled()) {
                    if (count($restaurant->orders) > 0) {
                        foreach ($restaurant->orders as $restaurantOrder) {

                            $scheduleDate = json_decode($restaurantOrder->schedule_date);
                            $scheduleDate = $scheduleDate->date;
                            $scheduleSlot = json_decode($restaurantOrder->schedule_slot);
                            $scheduleSlotFrom = $scheduleSlot->open;

                            $scheduledDateTime = Carbon::createFromFormat('Y-m-d h:i A', $scheduleDate . ' ' . $scheduleSlotFrom);

                            $reduceTime = $scheduledDateTime->subMinutes($minsSetByAdmin);

                            if (Carbon::parse($reduceTime) <= $now) {
                                if ($restaurantOrder->orderstatus_id == 11) {
                                    // if order is already confimed by store, then make it preparing...
                                    $restaurantOrder->orderstatus_id = 2;

                                    $this->smsAndPushToDelivery($restaurantOrder->restaurant_id, $restaurantOrder->unique_order_id);

                                } else {
                                    if ($restaurant->auto_acceptable) {
                                        //if autoacceptablem then make it preparing
                                        $restaurantOrder->orderstatus_id = 2;

                                        $this->smsAndPushToDelivery($restaurantOrder->restaurant_id, $restaurantOrder->unique_order_id);

                                    } else {

                                        $restaurantOrder->orderstatus_id = 1; // else new order...

                                        $this->sendPushNotificationStoreOwner($restaurantOrder->restaurant_id, $restaurantOrder->unique_order_id);
                                        $this->smsToRestaurant($restaurantOrder->restaurant_id, $restaurantOrder->total);
                                    }
                                }

                                $restaurantOrder->save();
                            }
                        }
                    }
                }

            }
        }

        // $schedule->command('schedule:restaurants')->everyMinute();
    }

    /**
     * @param $restaurant_id
     */
    private function sendPushNotificationStoreOwner($restaurant_id, $unique_order_id)
    {
        if (config('appSettings.oneSignalAppId') != null && config('appSettings.oneSignalRestApiKey') != null) {
            $restaurant = Restaurant::where('id', $restaurant_id)->first();
            if ($restaurant) {
                //get all pivot users of restaurant (Store Ownerowners)
                $pivotUsers = $restaurant->users()
                    ->wherePivot('restaurant_id', $restaurant_id)
                    ->get();

                //filter only res owner and send notification.
                foreach ($pivotUsers as $pU) {
                    if ($pU->hasRole('Store Owner')) {

                        $message = config('appSettings.restaurantNewOrderNotificationMsg');

                        $url = config('appSettings.storeUrl') . '/public/store-owner/order/' . $unique_order_id;

                        $userId = (string) $pU->id;

                        $contents = array(
                            'en' => $message,
                        );

                        $appId = DotenvEditor::getValue('ONESIGNAL_APP_ID');
                        $apiKey = DotenvEditor::getValue('ONESIGNAL_REST_API_KEY');

                        $fields = array(
                            'app_id' => $appId,
                            'include_external_user_ids' => array($userId),
                            'channel_for_external_user_ids' => 'push',
                            'contents' => $contents,
                            'url' => $url,
                        );

                        $fields = json_encode($fields);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ' . $apiKey));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $response = curl_exec($ch);
                        curl_close($ch);

                    }
                }
            }
        }
    }

    /**
     * @param $restaurant_id
     */
    private function smsAndPushToDelivery($restaurant_id, $unique_order_id)
    {
        //get restaurant
        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        if ($restaurant) {
            $pivotUsers = $restaurant->users()
                ->wherePivot('restaurant_id', $restaurant->id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Delivery Guy');
                })
                ->with('delivery_guy_detail', 'delivery_collections')
                ->get();
            foreach ($pivotUsers as $pU) {
                $inhand_cash = $pU->delivery_collection ? $pu->delivery_collection->amount : 0;
                $cash_limit = $pU->delivery_guy_detail->cash_limit;
                if ($cash_limit == 0) {
                    $is_in_limit = true;
                } else {
                    $inhand_cash < $cash_limit ? $is_in_limit = true : $is_in_limit = false;
                }

                if ($pU->delivery_guy_detail->is_notifiable && $pU->delivery_guy_detail->status && $is_in_limit) {
                    $message = config('appSettings.defaultSmsDeliveryMsg');
                    // As its not an OTP based message Nulling OTP
                    $otp = null;
                    $smsForDelivery = true;
                    $smsnotify = new Sms();
                    $smsnotify->processSmsAction('OD_NOTIFY', $pU->phone, $otp, $message, $smsForDelivery);

                    //send push notification to delivery
                    if (config('appSettings.enablePushNotification') && config('appSettings.enablePushNotificationOrders') == 'true') {
                        $notify = new PushNotify();
                        $notify->sendPushNotification('TO_DELIVERY', $pU->id, $unique_order_id);
                    }

                }
            }
        }
    }

    /**
     * @param $restaurant_id
     * @param $orderTotal
     */
    private function smsToRestaurant($restaurant_id, $orderTotal)
    {
        //get restaurant
        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        if ($restaurant) {
            if ($restaurant->is_notifiable) {
                //get all pivot users of restaurant (Store Ownerowners)
                $pivotUsers = $restaurant->users()
                    ->wherePivot('restaurant_id', $restaurant_id)
                    ->get();
                //filter only res owner and send notification.
                foreach ($pivotUsers as $pU) {
                    if ($pU->hasRole('Store Owner')) {
                        // Include Order orderTotal or not ?
                        switch (config('appSettings.smsRestOrderValue')) {
                            case 'true':
                                $message = config('appSettings.defaultSmsRestaurantMsg') . round($orderTotal);
                                break;
                            case 'false':
                                $message = config('appSettings.defaultSmsRestaurantMsg');
                                break;
                        }
                        // As its not an OTP based message Nulling OTP
                        $otp = null;
                        $smsnotify = new Sms();
                        $smsnotify->processSmsAction('OD_NOTIFY', $pU->phone, $otp, $message);
                    }
                }
            }
        }
    }
/**
 * Register the commands for the application.
 *
 * @return void
 */
    public function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
};
