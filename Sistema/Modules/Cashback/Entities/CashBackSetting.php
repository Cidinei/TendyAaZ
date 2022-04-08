<?php

namespace Modules\Cashback\Entities;

use Illuminate\Database\Eloquent\Model;

class CashBackSetting extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cashback_settings';

    protected $fillable = [
        'restaurant_edit',
        'sum_total_amount',
        'version'
    ];
}
