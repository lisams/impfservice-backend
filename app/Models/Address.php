<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['street_address', 'zip_code', 'city'];

    /**
     * address belongs to many locations
     */
    public function locations() : BelongsToMany {
        return $this->belongsToMany(Location::class);
    }

    /**
     * address belongs to many users location
     */
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class);
    }

}
