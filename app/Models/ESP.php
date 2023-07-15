<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ESP extends Model
{
    use HasFactory;
    protected $table = 'esp32';
    protected $guarded = [];
}
