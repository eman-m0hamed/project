<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'classification',
        'prop_of_seiz',
        'prop_of_non_seiz',
        'patient_id',

    ];

    public function User(){
        return $this->belongsTo('App\Models\User');
    }
}
