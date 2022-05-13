<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Symptom extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [

        'name',
    ];

    public function User(){
        return $this->belongsToMany('App\Models\User');
    }

}
