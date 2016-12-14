<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 26.11.2016
 * Time: 22:57
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */

    protected $redirectTo = '/admin';

    /*
     * Кастомная аутентификация
     *
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1]))
        {
            // Authentication passed...
            return redirect()->intended('/admin');
        }
        /*else
        {
            return redirect()->intended('/');
            //вывести ошибку //return redirect()->intended('/');
        }*/
    }

    /*
     * Кастомная регистрация
     * Отличается от обычной тем что юзер сразу не логинится. Админ сначала должен ему статус 1 поставить
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:100',
            'email' => 'required|unique:users|max:250|unique:confirm_users|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if(!empty($user->id))
        {
            return Redirect::back()->with('message','Все классно, админ подтвердит');
        }
        else {
            return Redirect::back()->with('message','Беда с базой, попробуй позже');
        }
    }
}