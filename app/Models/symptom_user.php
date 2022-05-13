<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class symptom_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'symptom_id',
        'user_id',

    ];

    public function User(){
        return $this->belongsToMany('App\Models\User');
    }

    // public function doctor(){
    //     return $this->belongsToMany('App\Models\doctor');
    // }
}
