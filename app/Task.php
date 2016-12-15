<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'body'
    ];

    protected $table = 'companies'; // table name

    public function company() {

        /*return $this->hasManyThrough(
            'App\Company', 'App\User',
            'client_id', 'manager_id', 'id'
        );*/

        //return $this->belongsTo('App\User', 'client_id');
        return $this->belongsToMany("App\Company", "user_in_company", "id_company", "id_user");

        //return $this->belongsToMany('App\User', 'companies', 'client_id', 'manager_id', 'id');
    }
}
