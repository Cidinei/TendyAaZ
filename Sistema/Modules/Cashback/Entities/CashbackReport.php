<?php

namespace Modules\Cashback\Entities;

use App\Order;
use App\Restaurant;
use App\User;
use Illuminate\Database\Eloquent\Model;

class CashbackReport extends Model
{
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'order_id',
        'percentage',
        'amount_real',
        'amount_paid'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
