<?php

namespace App\Http\Controllers;

use App\Http\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $courses = Course::orderByDesc('created_at')->paginate(20);

        return view('home', ['courses' => $courses]);
    }
}
