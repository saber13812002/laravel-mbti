<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionController;
use App\Models\Question;
// use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('')->group(function () {
    Route::get('/', function () {
        // $responses = Http::get('https://api.quotable.io/quotes?maxLength=166');
        return view('users.home');
    });
    Route::get('/mulai-test-mbti', function () {
        $question = Question::all();
        return view('users.dashboard',['questions' => $question]);
    });
    Route::post('/hasil', [QuestionController::class, 'calculate']);
    Route::get('/hasil2', function(){
        return view('mbti.hasil');
    });
});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('admin/login');
    });
    Route::get('/login', [AdminController::class, 'index'])->name('login')->withoutMiddleware('auth');
    Route::post('/login', [AdminController::class, 'login'])->withoutMiddleware('auth');
    Route::post('/register', [AdminController::class, 'register']);
    Route::get('/register', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/post', function () {
        return view('admin.post');
    })->name('post');
    Route::get('/post/add', function () {
        return view('admin.post');
    })->name('post.add');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/edit/{id}', [PostController::class, 'update']);
    Route::post('/post/add', [PostController::class, 'store']);
    Route::get('/report', function () {
        return view('admin.report');
    })->name('report');
    Route::get('/questions', function () {
        return view('admin.questions');
    })->name('questions');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
});
