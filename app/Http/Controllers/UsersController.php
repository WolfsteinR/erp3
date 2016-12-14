<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = json_encode(User::orderBy('created_at')->paginate(0));
        // page Heading
        $title = 'Users';
        // return to our view (home.blade.php)
        return view('users')->withUsers($users)->withTitle($title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        // page Heading
        $title = 'User';
        // return to our view (home.blade.php)
        //return view('user_edit')->withUser($user)->withTitle($title);
        return view('user_edit')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if(!empty($request->input('name')))
        {
            $user->name = $request->input('name');
        }
        if(!empty($request->input('active')))
        {
            $user->active = 1;
        }
        if(!empty($request->input('rule')) || $request->input('rule') != 'Выберите роль')
        {
            $user->role = $request->input('rule');
            if($user->active == 1) {
                Mail::send('emails.activate_user', ['name' => $user->name, 'message' => 'Message'], function ($message) use ($user)
                {
                    $message->from('wolfsz@yandex.ru', 'Test.ERP');
                    $message->to($user->email);
                }); // send email about activate and role for new user ERP system
            }
        }
        $user->save();
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
