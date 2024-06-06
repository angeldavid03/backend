<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    protected $table = 'admin';
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:30',
            'password' => 'required|string|min:6',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:admin,email',
            'foto' => 'nullable|image|max:2048',
        ]);
    }

    /** 
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\admin
     */
    protected function create(array $data)
    {
        return admin::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],

        ]);
    }
}
