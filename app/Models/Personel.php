<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Personel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['fname', 'lname', 'username', 'password', 'email', 'type_id'];

    protected $hidden = ['password', 'remember_token'];
}
