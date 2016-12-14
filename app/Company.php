<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'website'
    ];
}