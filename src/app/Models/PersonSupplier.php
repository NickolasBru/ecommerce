<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonSupplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person_supplier';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'personsupplier_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'company_name',
        'vat_number',
        'products_count'
    ];

    /**
     * A person belongs to a user.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }

    /**
     * A personSupplier has many productsSupplier.
     *
     * @return HasMany
     */
    public function productSupplier(): HasMany
    {
        return $this->hasMany(ProductSupplier::class, 'personsupplier_id', 'personsupplier_id');
    }

}

