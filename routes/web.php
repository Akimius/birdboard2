<?php

use App\Http\Controllers\ProjectController;
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
        Route::post('', [ProjectController::class, 'store']);

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    }
);
