<?php

use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TaskApiController::class)->group(function () {
    Route::get('tasks', 'index')->name('tasks');
    Route::post('tasks', 'store')->name('tasks.store');
    Route::put('tasks/{id}', 'update')->name('tasks.update');
    Route::get('tasks/{id}', 'show')->name('tasks.show');
    Route::delete('tasks/{id}', 'delete')->name('tasks.delete');
});
