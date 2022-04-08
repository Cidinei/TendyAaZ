<?php
if(isset($request->delivery_radius)) {
    $user->delivery_guy_detail->delivery_radius = $request->delivery_radius;
}

