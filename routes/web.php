<?php

use App\Models\TaskHistory;
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
    $data = TaskHistory::join('users', 'users.id','=', 'task_histories.user_id')
        ->join('tasks', 'tasks.id','=', 'task_histories.task_id')
        ->select('tasks.id', 'tasks.title', 'tasks.description','users.name','task_histories.status', 'task_histories.created_at')
        ->get();
    return $data;
});
