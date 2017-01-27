<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\User;

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
        if($request->input('active') !== NULL)
        {
            $user->active = 1;
        }
        else
        {
            $user->active = 0;
        }
        if(!empty($request->input('rule')) && $request->input('rule') != 'Выберите роль')
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
     * Form for adding manager to new client
     */
    function form_add_manager_to_client()
    {
        // ПРЕДУСМОТРЕТЬ ПОТОМ изменение менеджера
        $managers = User::where('role', 'manager')->paginate(0);
        $clients = User::where('role', 'client')->orderBy('created_at')->get(); // брать только клиентов без менеджера
        // Проверяем клиентов на наличие менеджера для них
        foreach ($clients as $key => $client) {
            $query = DB::select('select id_client from manager_to_client where id_client = ? limit 1', [$client->id]);
            if(!empty($query)) {
                $clients->forget($key);
            }
        }
        return view('forms/add_manager_to_client', ['managers'=>$managers, 'clients'=>$clients]);
    }

    /**
     * Adding manager to new client
     */
    function add_manager_to_client(Request $request)
    {
        DB::insert('insert into manager_to_client (id_manager, id_client) values (?, ?)', [Input::get('manager'), Input::get('client')]);
        return redirect('/admin/add-manager-to-client');
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
