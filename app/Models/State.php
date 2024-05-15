<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
     
    public function team():BelongsTo{
        return $this->BelongsTo(Team::class);
    }

    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(employee::class);
    }

    public function cities():HasMany
    {
        return $this->hasMany(City::class);
    }
}
