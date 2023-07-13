<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class DashboardController extends Controller
{
    public function dashboard()
    {
        if(Auth::check()){

            $users = User::with(['interests','roles'])->paginate(5);

            return view('dashboard',compact('users'));
        }
  
        return redirect("login")->withErrors([
            'message' => 'Opps! You do not have access. Please login with your credentials',
        ]);
    }
}
