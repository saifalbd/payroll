<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function loginPage()
    {
        return Inertia::render("Login");
    }


    public function login(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:admin,employee'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        $type = $request->type;
        $email = $request->email;
        $password = $request->password;

        $email = $request->email;
        $password = $request->password;
        $has = $type == 'admin' ? User::query()->where('email', $email)->first() : Employee::query()->where('email', $email)->first();
        if (!$has) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
                'password' => [__('auth.failed')],
            ]);
            return null;
        }

        $modelPass = $has->password;

        if (!Hash::check($password, $modelPass)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
                'password' => [__('auth.failed')],
            ]);
            return null;
        }


        Session::flush();
        if ($type == 'admin') {
            Auth::guard('web')->login($has);
        } else {
            Auth::guard('employee')->login($has);
        }

     
        return Inertia::location(route('home'));
    }
}
