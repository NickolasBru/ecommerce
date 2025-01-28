<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'cover_img_url',
        'sku',
        'price',
        'stock_quantity',
        'is_active',
        'category_id'
    ];

    /**
     * A product has one category.
     *
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Categories::class);
    }

    /**
     * A product has many suppliers.
     *
     * @return HasMany
     */
    public function productSupplier(): HasMany
    {
        return $this->hasMany(ProductSupplier::class, 'product_id', 'product_id');
    }

    /**
     * A product has a category.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }

}

