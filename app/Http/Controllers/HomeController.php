<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function profile(){
        return view('admin.profile');
    }
    public function home(){
        return view('home');
    }
}
