<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Segal extends Model
{
    use HasFactory;
    protected $table='segals';
    protected $guarded = [];


    public function user_segals(): HasMany
    {
        return $this->hasMany(User::class,'id');
    }


}
