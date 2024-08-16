<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }
    public function __construct()
    {
        $this->middleware('auth');
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
            'employee_slug'  => ['required', 'string', 'max:255'],
            'user_name'  => ['required', 'string', 'max:255'],
            // 'department' => ['required', 'string', 'max:100'],
            'level'      => ['required', 'string', 'max:100'],
            'password'   => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        $employee= Employee::where('employee_slug',$data['employee_slug'] )->first();
        $user = User::create([
            // 'full_name'  => $employee->employee_full_name,
            'user_name'  => $data['user_name'],
            'user_slug'  => $employee->employee_slug,
            // 'department' => $data['department'],
            'level'      => $data['level'],
            'employee_id'=> $employee->id, 
            'password'   => Hash::make($data['password']),
        ]);
        $employee->user_id =  $user->id;
        $employee->save();

        return $user;
    }

}
