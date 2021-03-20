<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'address_id'];

    /**
     * location belongs to many vaccinations
     */
    public function vaccinations() : BelongsToMany {
        return $this->belongsToMany(Vaccination::class)->withTimestamps();
    }

    /**
     * book has many images
     */
    public function address() : BelongsTo {
        return $this->belongsTo(Address::class);
    }
}
