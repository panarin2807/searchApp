<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_th', 'name_en'
    ];

    // public function groups()
    // {
    //     return $this->hasOne(Group::class);
    // }

    public function group()
    {
        return $this->belongsTo(Group::class);
        //return $this->hasOne(Curriculum::class);
    }

    public function files(){
        return $this->hasMany(ProjectFile::class);
    }

    public function relas()
    {
        return $this->hasMany(ProjectRela::class);
    }

    public function curricular()
    {
        $this->belongsTo(Curriculum::class);
        //return $this->hasOne(Curriculum::class);
    }
}
