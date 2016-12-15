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

        /*return $this->hasManyThrough(
            'App\Company', 'App\User',
            'client_id', 'manager_id', 'id'
        );*/

        //return $this->belongsTo('App\User', 'client_id');
        return $this->belongsToMany("App\User", "user_in_company", "id_company", "id_user");

        //return $this->belongsToMany('App\User', 'companies', 'client_id', 'manager_id', 'id');
    }
}