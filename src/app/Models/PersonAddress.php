<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonAddress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person_address';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'personaddress_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'tp_address', //1-billing, 2-shipping, 3-other
        'street',
        'city',
        'state',
        'postal_code',
        'country_id',
        'is_primary'
    ];

    /**
     * A cartitem belongs to a cart.
     *
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }

    /**
     * A cartitem belongs to a cart.
     *
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(Countries::class, 'country_id', 'country_id');
    }

}

