<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{
    use HasFactory;
    protected $table='notes';
    protected $guarded = [];


    public function user_note(): HasMany
    {
        return $this->hasMany(User::class,'id');
    }


}
