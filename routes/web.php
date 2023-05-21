<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PrincipalController;

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

/*
|--------------------------------------------------------------------------
| Controlador de la página principal
|--------------------------------------------------------------------------
*/

Route::get('/', [PrincipalController::class, 'index'])
    ->name('principal')
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| Controlador para la gestion de tareas
|--------------------------------------------------------------------------
*/
Route::get('/tasks', [TasksController::class, 'index'])
    ->name('tasks')
    ->middleware('auth');

Route::get('/tasks/create', [TasksController::class, 'create'])
    ->name('tasks.create')
    ->middleware('auth');

Route::post('/create-task', [TasksController::class, 'store'])
    ->name('tasks.store')
    ->middleware('auth');

Route::post('/delete-task', [TasksController::class, 'destroy'])
    ->name('task.delete')
    ->middleware('auth');

Route::put('/update-favorite-task', [TasksController::class, 'updateFavoriteTask'])
    ->name('task.update.favorite')
    ->middleware('auth');

Route::put('/save-task', [TasksController::class, 'updateTask'])
    ->name('task.update')
    ->middleware('auth');

Route::get('/tasks/{task}', [TasksController::class, 'show'])
    ->name('task.show')
    ->middleware('auth');

Route::put('/complete-task', [TasksController::class, 'completeTask'])
    ->name('task.complete')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Controladores de autenticacion y registro de usuarios
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'index'])
    ->name('login')
    ->middleware('guest');

Route::post('/login-user', [LoginController::class, 'login'])
    ->name('login_user')
    ->middleware('guest');

Route::get('/register', [RegisterController::class, 'index'])
    ->name('register')
    ->middleware('guest');

Route::post('/register-user', [RegisterController::class, 'store'])
    ->name('register_user')
    ->middleware('guest');

Route::get('/logout', [LoginController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');
