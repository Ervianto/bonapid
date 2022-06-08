<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $input = $request->all();

        $rules = [
            'email'                   => 'required',
            'password'                => 'required',
        ];

        $messages = [
            'email.required'             => 'email harus diisi',
            'password.required'          => 'Password harus diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if (auth()->user()->role == "admin") {
                Alert::success('Sukses', 'Berhasil Login Admin');
                return redirect('/admin/dashboard');
            } else {
                if (auth()->user()->status == "1") {
                    Alert::success('Sukses', 'Berhasil Login');
                    return redirect('/');
                } else {
                    Alert::error('Gagal', 'Akun Belum Diverifikasi');
                    return redirect()->route('customer.signin');
                }
            }
        } else {
            Alert::error('Gagal', 'Akun Belum Terdaftar');
            return redirect()->route('customer.signin');
        }
    }
}
