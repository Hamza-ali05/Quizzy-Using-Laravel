<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\OptionController;
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
Route::get('/logout', [AuthController::class, 'showLogoutPage'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// Admin Routes
// =====================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ----- Quiz Routes -----
    
    Route::get('quizzes', [QuizController::class,'index'])->name('quizzes.index');
    Route::get('quizzes/create', [QuizController::class,'create'])->name('quizzes.create');
    Route::post('quizzes', [QuizController::class,'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [QuizController::class,'show'])->name('quizzes.show');
    Route::get('quizzes/{quiz}/edit', [QuizController::class,'edit'])->name('quizzes.edit');
    Route::put('quizzes/{quiz}', [QuizController::class,'update'])->name('quizzes.update');
    Route::delete('quizzes/{quiz}', [QuizController::class,'destroy'])->name('quizzes.destroy');

    // ----- Question Routes (tied to quizzes) -----
    Route::get('quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');

    //Questions Management
    
    Route::get('questions', [QuestionController::class,'index'])->name('questions.index');
    Route::get('questions/{question}/edit', [QuestionController::class,'edit'])->name('questions.edit');
    Route::put('questions/{question}', [QuestionController::class,'update'])->name('questions.update');
    Route::delete('questions/{question}', [QuestionController::class,'destroy'])->name('questions.destroy');

    // ----- Option Routes -----
    
    Route::get('options', [OptionController::class, 'index'])->name('options.index');
    Route::get('options/create', [OptionController::class, 'create'])->name('options.create');
    Route::post('options', [OptionController::class, 'store'])->name('options.store');
    Route::get('options/{option}/edit', [OptionController::class, 'edit'])->name('options.edit');
    Route::put('options/{option}', [OptionController::class, 'update'])->name('options.update');
    Route::delete('options/{option}', [OptionController::class, 'destroy'])->name('options.destroy');
    

    // ----- Result Routes -----
    Route::get('results', [ResultController::class, 'index'])->name('results.index');
});

// =====================
// Student Routes
// =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/quizzes/{quiz}/attempt/{index?}', [StudentController::class, 'attempt'])->name('quizzes.attempt');
    Route::post('/quizzes/{quiz}/attempt/{index}', [StudentController::class, 'submitAnswer'])->name('quizzes.submitAnswer');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/result', [ResultController::class, 'show'])->name('quizzes.result');
});



// =====================
// Shared Routes (Admins & Students)
// =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
});
