<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employees():HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function departments():HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function countries(): hasMany
    {
        return $this->hasMany(Country::class);
    }

    public function members():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
