<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $guarded = [];

    public function worker_paymant(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
    public function project_paymant(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }



}
