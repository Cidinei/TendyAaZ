<?php


namespace Modules\NotifyStoreAndDeliveryGuy\Traits;

use App\Restaurant;
use OneSignal;


trait PushNotifyTrait
{
    /**
     * @param $msmTo
     * @param $restaurant_id
     */
    public static function oneSignalNotification($msmTo,$restaurant_id)
    {

        if ($msmTo == 'Delivery Guy'){
            // Credenciais oneSignal to 'Delivery Guy' Settings MarketDev    
            $onesignal_app_id = config('appSettings.delivery_onesignal_app_id');
            $onesignal_channell_id = config('appSettings.delivery_onesignal_channell_id');
            $onesignal_key_id = 'Authorization: Basic ' . config('appSettings.delivery_onesignal_key_id');
            $message = config('appSettings.defaultSmsDeliveryMsg');

         } else { 
            // Credenciais oneSignal to 'Store Owner' Settings MarketDev
            $onesignal_app_id = config('appSettings.store_onesignal_app_id');
            $onesignal_channell_id = config('appSettings.store_onesignal_channell_id');
            $onesignal_key_id = 'Authorization: Basic ' . config('appSettings.store_onesignal_key_id');
            $message = config('appSettings.defaultSmsRestaurantMsg');
        }

        $onesignal_player_ids = [];

        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        if ($restaurant) {
            $pivotUsers = $restaurant->users()
                ->wherePivot('restaurant_id', $restaurant_id)
                ->get();
            foreach ($pivotUsers as $pU) {
                if ($pU->hasRole($msmTo)) {
                    $onesignal_player_ids[]= $pU->email;
                }
            }
        }

        $content      = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => $onesignal_app_id,
            'include_external_user_ids' => $onesignal_player_ids,
            'data' => array(
                "foo" => "bar"
            ),
            'contents' => $content,
            'android_channel_id' => $onesignal_channell_id,
            'ios_sound' => 'neworder.wav'
        );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            $onesignal_key_id
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $oneSignalPush = curl_exec($ch);
        curl_close($ch);
    }


}
