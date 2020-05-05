<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $user = Auth::user();

        return view('profile', ['user' => $user]);
    }

    public function changeName(){
        $user = Auth::user();

        return view('changeName', ['user' => $user]);
    }

    public function saveName(Request $req){
        $req->validate(['name' => 'required|min:3|max:255',
                        'surname' => 'required|min:3|max:255'],
                       ['name.*' => "Ім'я має містити принаймні 3 символи!",
                        'surname.*' => 'Прізвище має містити принаймні 3 символи!']);

        $user = Auth::user();
        $user->name = $req->input('name');
        $user->surname = $req->input('surname');
        $user->save();
        
        return redirect()->route('profile');
    }
}
