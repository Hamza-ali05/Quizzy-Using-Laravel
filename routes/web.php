<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;


// =====================
// Home
// =====================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// =====================
// Authentication Routes
// =====================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// Admin Routes
// =====================

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // ----- Quiz Routes -----
    
    //Route::get('quizzes', [QuizController::class,'index'])->name('quizzes.index');
    Route::get('quizzes/create', [QuizController::class,'create'])->name('quizzes.create');
    Route::post('quizzes', [QuizController::class,'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [QuizController::class,'show'])->name('quizzes.show');
    Route::delete('quizzes/{quiz}', [QuizController::class,'destroy'])->name('quizzes.destroy');

    // ----- Question Routes (tied to quizzes) -----
    Route::get('quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');

    //Questions Management
    Route::get('questions', [QuestionController::class,'index'])->name('questions.index');
    Route::get('questions/{question}/edit', [QuestionController::class,'edit'])->name('questions.edit');
    Route::put('questions/{question}', [QuestionController::class,'update'])->name('questions.update');
    Route::delete('questions/{question}', [QuestionController::class,'destroy'])->name('questions.destroy');

    // ----- Result Routes -----
    Route::get('results', [ResultController::class, 'index'])->name('admin.results');
});

// =====================
// Student Routes
// =====================

Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/quizzes/{quiz}/attempt/{index?}', [StudentController::class, 'attempt'])->name('quizzes.attempt');
    Route::post('/quizzes/{quiz}/attempt/{index}', [StudentController::class, 'submitAnswer'])->name('quizzes.submitAnswer');
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::post('/quizzes/{quiz}/auto-submit', [StudentController::class, 'autoSubmit'])->name('quizzes.autoSubmit');

    
});

// =====================
// Shared Routes (Admins & Students)
// =====================

   Route::middleware(['auth'])->group(function () {
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
});
