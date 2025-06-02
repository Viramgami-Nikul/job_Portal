<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function jobType(){
        //joytype model belongs to relation job

        return $this->belongsTo(JobType::class);
    }
    public function category(){
        //category model belongs to relation job

        return $this->belongsTo(Category::class);


    }

    //this relation show the application count
    
    public function applications(){
        return $this->hasMany(JobApplication::class);
    }

    public function user(){
        //User model belongs to relation job

        return $this->belongsTo(User::class);


    }

}
