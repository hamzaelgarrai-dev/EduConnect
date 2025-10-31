<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Cour extends Authenticatable implements AuthorizableContract
{
    use HasFactory , HasRoles, Authorizable , HasApiTokens;


    protected $fillable = ["title", "description" ];

    public function user(){
       return $this->belongsTo(User::class);
    }
}
