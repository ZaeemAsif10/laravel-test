<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/add-tasks', [TaskController::class, 'addTasks']);
Route::post('/store-tasks', [TaskController::class, 'storeTasks']);
Route::get('/edit-task/{id}', [TaskController::class, 'editTask']);
Route::post('/update-tasks', [TaskController::class, 'updateTasks']);
Route::get('/delete-task', [TaskController::class, 'deleteTask']);
