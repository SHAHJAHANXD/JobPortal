<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appliedjob extends Model
{
    use HasFactory;
    protected $fillable = [
        "employer_id",
        "job_id",
        "candidate_id",
        "cv",
        "cover_letter"
    ];
    public function PostJobs()
    {
        return $this->belongsTo(PostJob::class , "job_id" , 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class , "candidate_id" , 'id');
    }
}
