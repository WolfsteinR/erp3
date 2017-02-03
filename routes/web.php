<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return redirect('/');
});
//Route::get('/admin', 'UsersController@index');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', function () {
        $company = '';
        $manager = '';
        if(Auth::user()->role == 'client') {
            $company = DB::select('select id_company from user_in_company where id_user = ?', [Auth::user()->id]);
            $manager = DB::select('select id_manager from manager_to_client where id_client = ?', [Auth::user()->id]);
        }
        /*print '<pre>';
        print_r($manager);exit;*/
        return view('admin', ['company'=>$company, 'manager'=>$manager]);
    }); // administrator page
    Route::get('/admin/users', 'UsersController@index'); // list users on administrator page
    Route::get('/admin/users/{id}', 'UsersController@show'); // show user info and form for edit them
    Route::get('/admin/companies', 'CompanyController@index'); //show all companies

    Route::post('/admin/users/user-edit/{id}', 'UsersController@update'); // post info from from editing user
    Route::get('/admin/create-company/{id}', function() {
        return view('forms.company_form', ['link'=>'create-company']);
    }); //form for clients add info about them company
    Route::get('/admin/edit-company/{id}', 'CompanyController@edit'); //form for clients edit info about them company
    //Route::get('/admin/add-manager-to-company', 'CompanyController@form_add_manager_to_company'); // form for adding manager to company

    Route::get('upload', 'UploadsController@index');
    Route::post('upload/uploadFiles', 'UploadsController@multiple_upload');

    //Route::post('/admin/add-manager-company', 'CompanyController@add_manager_to_company');
    Route::post('/admin/create-company/{id}', 'CompanyController@create');
    Route::post('/admin/update-company/{id}', 'CompanyController@update');

    /* Adding manager to new client */
    Route::get('/admin/add-manager-to-client', 'UsersController@form_add_manager_to_client');
    Route::post('/admin/add-manager-to-client', 'UsersController@add_manager_to_client');

    /* TASKS */
    Route::get('/admin/tasks', 'TasksController@index'); //show all tasks
    Route::get('/admin/create-task', 'TasksController@create'); // show form for creating tasks
    Route::get('/admin/update-task/{id}', 'TasksController@edit');  // show form for editing tasks
    Route::get('/admin/show-task/{id}', 'TasksController@show'); // show task for specialist
    Route::post('/admin/create-task/{id}', 'TasksController@store'); // client create new task
    Route::post('/admin/update-task/{id}', 'TasksController@update'); // client update new task
    /* TASKS */
});
//Auth::routes();
//Auth Routes
Route::post('/login', 'Auth\LoginController@login');//Route::post('/login', 'AuthController@authenticate');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('/home', 'HomeController@index');
//