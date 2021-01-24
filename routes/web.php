<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(
    [
        'middleware' => 'auth',
        'prefix'     => '/projects'
    ],
    function () {
        Route::get('', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('project.show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::post('', [ProjectController::class, 'store'])->name('project.store');
        Route::patch('/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::post('{project}/tasks', [ProjectTasksController::class, 'store'])->name('task.store');
        Route::patch('{project}/tasks/{task}', [ProjectTasksController::class, 'update'])->name('task.update');

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    }
);
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

