<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'person_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tp_person' // 1-customer; 2-supplier; 3-other
    ];

    /**
     * A person belongs to a user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * A person belongs to a user.
     *
     * @return HasOne
     */
    public function personSupplier(): HasOne
    {
        return $this->hasOne(PersonSupplier::class, 'person_id', 'person_id');
    }

}

