<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function groups(){
        return $this->hasOne(Group::class);
    }

    public function curricular(){
        return $this->hasOne(Curriculum::class);
    }
}
