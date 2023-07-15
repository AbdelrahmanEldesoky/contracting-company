<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WorkerSegal extends Model
{
    use HasFactory;

    protected $table='worker_segal';
    protected $guarded = [];
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function segal(): BelongsTo
    {
        return $this->belongsTo(Segal::class);
    }


}
