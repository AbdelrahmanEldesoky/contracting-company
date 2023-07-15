<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WorkerSallary extends Model
{
    use HasFactory;

    protected $table='worker_salaries';
    protected $guarded = [];
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }




}
