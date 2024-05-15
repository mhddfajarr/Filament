<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function department():BelongsTo{
        return $this->belongsTo(Department::class);
    }
    public function country():BelongsTo{
        return $this->belongsTo(country::class);
    }
    public function state():BelongsTo{
        return $this->belongsTo(state::class);
    }
    public function city():BelongsTo{
        return $this->belongsTo(city::class);
    }

    public function team(): BelongsTo{
        return $this->belongsTo(Team::class);
    }
}
