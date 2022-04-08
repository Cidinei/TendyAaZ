<?php


namespace Modules\Cashback\Traits;


trait OrderTrait
{
    /**
     * @param $order
     */
    public static function payCashBack($order) {

        $restaurant = \App\Restaurant::find($order->restaurant->id);
        if($restaurant->cashback_status == 1) {

            $user = \App\User::find($order->user_id);
            $cashbacksetting = \Modules\Cashback\Entities\CashBackSetting::first();

            if (!empty($cashbacksetting)){

                $totalPay = 0;

                if(!empty($restaurant->cashback_percentage) && strpos($restaurant->cashback_percentage, '%') !== false) {
                    
                    $value = (intval(str_replace("%","",$restaurant->cashback_percentage)) / 100);

                    if( $cashbacksetting->sum_total_amount == 1) {
                        $totalPay = ($value * $order->total);
                    } else{
                        $totalPay = ($value * ($order->total- $order->delivery_charge));
                    }

                } else {
                    $totalPay = $restaurant->cashback_value;
                }

                if(isset($restaurant->cashback_limit_value) && !empty($restaurant->cashback_limit_value)) {
                    if($totalPay > $restaurant->cashback_limit_value) {
                        $totalPay = $restaurant->cashback_limit_value;
                    }
                }

                $user->deposit($totalPay * 100, ['description' => \Lang::get('cashback::default.cashback_description', ['order' => $order->unique_order_id])]);

                \Modules\Cashback\Entities\CashbackReport::create([
                    'restaurant_id' => $restaurant->id,
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'percentage' => $restaurant->cashback_percentage ?? 0,
                    'amount_real' => $order->total ?? 0,
                    'amount_paid' => $totalPay ?? 0,
                ]);
            }
        }
    }
}
