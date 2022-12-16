<?php

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


Route::get('/', function () {
    return redirect("login");
});
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/students/all', [App\Http\Controllers\Student\StudentController::class, 'index'])->name('all');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/students/delete', [App\Http\Controllers\Student\StudentController::class,'deleteindex'])->name('delete');
    Route::delete('/students/delete',[App\Http\Controllers\Student\StudentController::class,'delete'])->name('deleteById');
    Route::get('/students/create', [App\Http\Controllers\Student\StudentController::class, 'create'])->name('create');
    Route::post('/students/store',[App\Http\Controllers\Student\StudentController::class,'store'])->name('store');
    Route::get('/students/edit',[App\Http\Controllers\Student\StudentController::class,'edit'])->name('edit');
    Route::get('/students/fetch-student/{id}',[App\Http\Controllers\Student\StudentController::class,'fetchStudent'])->name('fetchStudent');
    Route::get('/students/fetch-student-list',[App\Http\Controllers\Student\StudentController::class,'fetchStudentList'])->name('fetchStudentList');
    Route::put('/students/update',[App\Http\Controllers\Student\StudentController::class,'update'])->name('update');
    Route::get('/students/delete-fetch-student-list',[App\Http\Controllers\Student\StudentController::class,'fetchStudentListDelete'])->name('fetchStudentListDelete');
    });