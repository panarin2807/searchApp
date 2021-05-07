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

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'project_groups', 'project_id', 'group_id');
        //return $this->belongsToMany(Group::class, 'project_groups', 'project_id', 'group_id');
        // return $this->belongsTo(Group::class);
        //return $this->hasOne(Curriculum::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function relas()
    {
        return $this->hasMany(ProjectRela::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_relas');
    }

    public function curricular()
    {
        $this->belongsTo(Curriculum::class);
        //return $this->hasOne(Curriculum::class);
    }
}
