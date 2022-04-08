<?php
if(\Module::find("DeliveryRadiusPro")->isEnabled() && isset($user->delivery_guy_detail->delivery_radius) && !empty($user->delivery_guy_detail->delivery_radius) && !empty($lat) && !empty($lng)) {
    if(\Modules\DeliveryRadiusPro\Http\Controllers\DeliveryRadiusProController::checkRadiusDelivery($lat, $lng, $order->restaurant, $user->delivery_guy_detail->delivery_radius)) {
        $alreadyAcceptedDeliveries->push($order);
    }
}else{
    $alreadyAcceptedDeliveries->push($order);
}
