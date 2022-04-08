<?php

if(isset($request->minimum_qty)) {
    $addonCategory->minimum_qty = $request->minimum_qty;
}

if(isset($request->minimum_qty)) {
    $addonCategory->maximum_qty = $request->maximum_qty;
}

$addonCategory->add_required = $request->input('add_required') ? 1 : 0;
