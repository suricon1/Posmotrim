<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\VerifyMail;
use App\Models\Vinograd\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('vinograd.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::add($request->all());
        Mail::to($user->email)->send(new VerifyMail($user));
        event(new Registered($user));

        return redirect()->route('vinograd.login')
            ->with('status', 'Проверьте свою электронную почту и нажмите на ссылку, чтобы подтвердить email.');
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('vinograd.login')
                ->withErrors('Извините, ваша ссылка не может быть идентифицирована.');
        }
        try {
            $user->verify();
            return redirect()->route('vinograd.login')->with('status', 'Ваш адрес электронной почты подтвержден. Теперь вы можете войти.');
        } catch (\DomainException $e) {
            return redirect()->route('vinograd.login')->withErrors($e->getMessage());
        }
    }

    public function loginForm()
    {
        return view('vinograd.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt([
            'email'	=>	$request->get('email'),
            'password'	=>	$request->get('password')
        ], $request->filled('remember')))
        {
            $user = Auth::user();
            if ($user->isWait()) {
                Auth::logout();
                return back()->withErrors('Вам закрыт вход на сайт! Это может быть по двум причинам:<br>
                                                    1) Вы не подтвердили свой Email. Проверьте свою электронную почту и нажмите на ссылку, чтобы подтвердить email.<br>
                                                    2) Ваш аккаунт был заблокирован. Обратитесь к администратору сайта.');
            }
            return redirect()->back();
        }
        return redirect()->back()->with('status', 'Неправильный логин или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('vinograd.home');
    }
}
