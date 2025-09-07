<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AlterUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;


class LoginController extends Controller
{
    public function showLoginForm(Request $request){
        return Inertia::render('Auth/Login', []);
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email|exists:alter_users',
            'password' => 'required|string',
        ],[
           'email.required' => 'Почта обязательнa',
           'email.exists' => 'Пользователь с таким email не найден',
           'password.required' => 'Пароль обязателен',
        ]);
        // поиск альтерюзер
        $alterUser = AlterUser::where('email', $request->email)->first();

        if(!$alterUser || !Hash::check($request->password, $alterUser->password)){
            return response()->json([
                'success' => false,
                'message' => 'false',
            ], 401);
        }
        Auth::guard('alter')->login($alterUser);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'true',
            'redirect' => route('index'),
        ]);

    }
    public function showRegisterForm(Request $request){
        return Inertia::render('Auth/Register', []);
    }
    public function register(Request $request){
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:alter_users'],
            'password' => ['required', 'string', 'min:2'],
        ]);

        $user = AlterUser::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if($user){
            Auth::login($user);
        }
        return response()->json([
            'success' => true,
            'message' => 'Регистрация',
            'redirect' => route('index')
        ]);
    }
    public function forgotPasswordShowForm(Request $request){
        return Inertia::render('Auth/ForgotPassword', []);
    }
    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:alter_users', //
        ], [
            'email.required' => 'Почта обязательна',
            'email.email' => 'Неверный формат почты',
            'email.exists' => 'Пользователь с такой почтой не найден',
        ]);
        // автоматическая отправка письма на ресет
        $status = Password::broker('alter_users')->sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['success' => true, 'message' => __($status)])
            : response()->json(['success' => false, 'message' => __($status)]);
    }
    public function showResetPasswordForm(Request $request)
    {
         return Inertia::render('Auth/ResetPassword', [
            'email' => $request->query('email'),
            'token' => $request->query('token'),
        ]);
    }
    //mirita@mail.com
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('alter_users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (AlterUser $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'success' => true,
                'message' => __($status),
            ])
            : response()->json([
                'success' => false,
                'message' => __($status),
            ]);
    }
}
