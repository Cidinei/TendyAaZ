<?php

namespace App\Http\Controllers;

use App\AcceptDelivery;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;

class Chatchy extends Controller {

    public function reId($slug) {
        return Restaurant::where('slug', $slug)->first()['id'];
    }

    public function dgId($uoid) {
        $id = Order::where('unique_order_id', $uoid)->first()->pluck('id')->toArray()[0];
        $dgId = AcceptDelivery::where('order_id', $id)->first();
        if ($dgId != '') {
            return $dgId->pluck('user_id')->toArray()[0];
        }return 0;
    }

}