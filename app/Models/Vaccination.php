<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'max_participants', 'location_id'];

    /**
     * location has many vaccinations
     */
    public function location() : BelongsTo {
        return $this->belongsTo(Location::class);
    }
}