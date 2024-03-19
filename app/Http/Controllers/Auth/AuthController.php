<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 1])) {
            return redirect()->route('admin.dashboard.index');
        } else if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 0])) {
            return redirect()->route('user.order.index');
        } else {
            return redirect()->back()->with(['gagal' => 'These credentials do not match our records.']);
        }
    }
    public function logout()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        return redirect('/auth/login');
    }
}
