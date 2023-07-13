<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInterest;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Arr;
use App\Jobs\WelcomeUserJob;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {   
        //Return with validation error message if input is empty
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //It will redirect to dashboard if everything is ok
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
        //Return back to login page with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:3|max:50',
            'interest' => 'required|array',
        ]);
           
        $data = $request->all(); 

        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        if($user){  
            $userId = $user->id;
            // insert user interests
            foreach ($data['interest'] as $key => $value) {
                $userInterest = UserInterest::create([
                    'user_id' => $userId,   
                    'interest' => $value              
                ]);
            }
            // Assign all roles to user
            $roles  = Role::pluck('id')->toArray(); 
            $mapped = Arr::map($roles, function (string $value, string $key)  use ($userId) {
                $role = RoleUser::create([
                    'user_id' => $userId,   
                    'role_id' => $value             
                ]);
            });
            
            // send welcome mail to user
            WelcomeUserJob::dispatch($user);
               
        }

        return $user;
    }

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
