<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LimitlessController;
use App\Http\Controllers\EmployeeTrackingController;
use App\Http\Controllers\EmployeeTracikingController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('{any}',[LimitlessController::class,'index'])->name('index');
// });


Route::controller(EmployeeTrackingController::class)->prefix('EmployeeTracking')->group(function () {
    Route::get('/remote/dashboard', 'Dashboard')->name('remote.dashboard');

    Route::get('/remote/request', 'RemoteRequest')->name('remote.request');
    Route::get('/remote/request/get/{id}', 'RemoteRequestGet')->name('remote.request.get');
    Route::post('/remote/request/store', 'RemoteRequestStore')->name('remote.request.store');
    Route::post('/remote/request/update', 'RemoteRequestUpdate')->name('remote.request.update');

    Route::get('/remote/monitoring', 'Monitoring')->name('remote.monitoring');

    Route::get('/remote/schedule', 'Schedule')->name('remote.schedule');

    Route::get('/remote/employee', 'RemoteEmployees')->name('remote.employees');
    Route::post('/remote/employee/store', 'RemoteEmployeesStore')->name('remote.employees.store');
    Route::post('/remote/employee/update', 'RemoteEmployeesUpdate')->name('remote.employees.update');

    Route::get('/remote/projects', 'Projects')->name('remote.projects');
    Route::post('/remote/projects/store', 'ProjectsStore')->name('remote.projects.store');
    Route::post('/remote/projects/update', 'ProjectsUpdate')->name('remote.projects.update');

    Route::get('/remote/task', 'Task')->name('remote.task');
    Route::post('/remote/task/store', 'TaskStore')->name('remote.task.store');
    Route::post('/remote/task/update', 'TaskUpdate')->name('remote.task.update');

    Route::get('/remote/meetings', 'Meetings')->name('remote.meetings');
    Route::post('/remote/meetings/store', 'MeetingsStore')->name('remote.meetings.store');
    Route::post('/remote/meetings/update', 'MeetingsUpdate')->name('remote.meetings.update');

});
