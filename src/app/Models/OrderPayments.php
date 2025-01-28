<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayments extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_payments';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'orderpayment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', //1-Pending, 2-Processing, 3-done, 4 - canceled;
        'method',
        'transaction_id',
        'paid_at'
    ];

    /**
     * A orderShipment belongsTo a order.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }

}

