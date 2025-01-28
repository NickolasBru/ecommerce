<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSupplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_supplier';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'productsupp_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'supplier_id',
    ];

    /**
     * A supplier has many products.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }

    /**
     * A prodcutsupplier belongs to a suppliers.
     *
     * @return BelongsTo
     */
    public function personSupplier(): BelongsTo
    {
        return $this->belongsTo(PersonSupplier::class, 'personsupplier_id', 'personsupplier_id');
    }

}

