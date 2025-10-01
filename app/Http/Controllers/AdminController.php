<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class AdminController extends Controller
{
    // Show the admin dashboard with all quizzes
    public function dashboard()
    {
        $quizzes = Quiz::with('creator')->get();
        return view('admin.dashboard', compact('quizzes'));
    }


    // Redirect to quiz creation form
    public function create()
    {
        return view('admin.create');
    }
}
