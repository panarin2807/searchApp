<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'detail'
    ];

    public function projects(){
        return $this->belongsToMany(Project::class,'project_groups','group_id','project_id');
    }

//     public function projects() {
//         return $this->hasMany(\App\Models\Project::class);
//    }
}
