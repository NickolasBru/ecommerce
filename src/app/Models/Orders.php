<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personcustomer_id',
        'status',
        'total_price'
    ];

    /**
     * An order has a Person.
     *
     * @return HasOne
     */
    public function personCustomer(): HasOne
    {
        return $this->hasOne(PersonAddress::class, 'personcustomer_id', 'personcustomer_id');
    }

    /**
     * An order has a shipment address.
     *
     * @return HasOne
     */
    public function orderShipment(): HasOne
    {
        return $this->hasOne(OrdersShipments::class, 'order_id', 'order_id');
    }

    /**
     * An order has a payment address.
     *
     * @return HasOne
     */
    public function orderPayment(): HasOne
    {
        return $this->hasOne(OrderPayments::class, 'order_id', 'order_id');
    }

}

