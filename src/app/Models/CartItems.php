<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItems extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cartitems_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    /**
     * A cartitem belongs to a cart.
     *
     * @return BelongsTo
     */
    public function carts(): BelongsTo
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'cart_id');
    }

}

