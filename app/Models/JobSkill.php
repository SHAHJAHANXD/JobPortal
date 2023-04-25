<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobSkill extends Model
{
    use HasFactory;
    protected $fillable = ['name','img'];
    public function skills(): BelongsTo
    {
        return  $this->belongsTo(Skills::class, 'name', 'name');
    }
    public function JobPostedSkills(): HasMany
    {
        return  $this->hasMany(PostJob::class, 'skills', 'name');
    }
}
