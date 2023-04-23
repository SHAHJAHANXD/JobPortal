<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'gender',
        'experience',
        'recruitments',
        'category',
        'job_type',
        'location',
        'status',
        'skills',
        'slug'
    ];
    public function Users()
    {
        return $this->belongsTo(User::class , "user_id" , 'id');
    }
    public function Skills()
    {
        return $this->belongsTo(JobSkill::class , "skills" , 'name');
    }

}
