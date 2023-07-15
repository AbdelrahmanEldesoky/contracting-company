<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProjectBudget extends Model
{
    use HasFactory;
    protected $table = 'project_budgets';
    protected $guarded = [];

    public function user_dof3a(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function project_solfa(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
