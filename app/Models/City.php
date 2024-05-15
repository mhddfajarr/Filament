<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function state():BelongsTo{
        return $this->belongsTo(state::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(employee::class);
    }

    public function team():BelongsTo{
        return $this->BelongsTo(Team::class);
    }

    
}
