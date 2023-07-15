<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $table='projects';
    protected $guarded = [];

  
    public function user_me(): HasMany
    {
        return $this->hasMany(User::class,'id');
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(MonthlyExpenses::class);
    }
    public function payment_p(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    public function payment_mizanya(): HasMany
    {
        return $this->hasMany(ProjectBudget::class);
    }

}
