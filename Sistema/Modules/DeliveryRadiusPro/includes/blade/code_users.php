<label class="col-lg-3 col-form-label mb-3">Radius in Km</label>
<div class="col-lg-9 mb-3">
    <input type="text" class="form-control form-control-lg" name="delivery_radius" placeholder="Radius in Km" value="<?=!empty($user->delivery_guy_detail->delivery_radius) ? $user->delivery_guy_detail->delivery_radius : "0"?>">
</div>
