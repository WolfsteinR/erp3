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
        return view('admin');
    }); // administrator page
    Route::get('/admin/users', 'UsersController@index'); // list users on administrator page
    Route::get('/admin/users/{id}', 'UsersController@show'); // show user info and form for edit them
    Route::get('/admin/companies', 'CompanyController@index'); //show all companies
    Route::get('/admin/tasks', 'TasksController@index'); //show all tasks
    Route::get('/admin/create-task/{id}', function() {
        return view('forms.task_form', ['link'=>'create-task']);
    }); // show form for creating tasks
    Route::get('/admin/update-task/{id}', 'TasksController@edit');
    Route::post('/admin/users/user-edit/{id}', 'UsersController@update'); // post info from from editing user
    Route::get('/admin/create-company/{id}', function() {
        return view('forms.company_form', ['link'=>'create-company']);
    }); //form for clients add info about them company
    Route::get('/admin/edit-company/{id}', 'CompanyController@edit'); //form for clients edit info about them company
    Route::post('/admin/create-company/{id}', 'CompanyController@create');
    Route::post('/admin/update-company/{id}', 'CompanyController@update');
    Route::post('/admin/create-task/{id}', 'TasksController@create'); // client create new task
    Route::post('/admin/update-task/{id}', 'TasksController@update'); // client update new task
});
//Auth::routes();
//Auth Routes
Route::post('/login', 'Auth\LoginController@login');//Route::post('/login', 'AuthController@authenticate');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('/home', 'HomeController@index');
