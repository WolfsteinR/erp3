<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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

    protected $table = 'companies'; // table name

    public function user() {
        return $this->belongsTo('App\User', 'client_id');
    }
}