<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;


//Before Login / Guest user
Route::inertia('/','Auth/Login')->name('login');
Route::inertia('/register','Auth/Register');
Route::post('/login',[AuthenticationController::class,'login']);

//Authenticated
Route::middleware(['auth'])->group(function () {
    Route::post('/register',[AuthenticationController::class,'store']);
    Route::post('/logout',[AuthenticationController::class,'logout']);
    Route::inertia('/studentlist','Student/Index')->name('student-index');
    Route::put('/updatestudent/{id}', [StudentsController::class, 'update']);
    Route::get('/getstudents',[StudentsController::class,'getStudents']);
    Route::delete('/deleteStudent/{id}', [StudentsController::class, 'destroy']);
    Route::post('/savestudent',[StudentsController::class,'store']);
});
