<?php

use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(TaskController::class)->group(function () {
        Route::get('tasks', 'getTasks')->name('tasks.getTasks');
        Route::get('tasks/{id}', 'getTask')->name('tasks.getTask');
        Route::post('tasks', 'createTask')->name('tasks.createTask');
        Route::put('tasks/{id}', 'updateTask')->name('tasks.updateTask');
        Route::delete('tasks/{id}', 'deleteTask')->name('tasks.deleteTask');
        Route::post('tasks/{taskId}/participants', 'addParticipantsToTask')->name('tasks.addParticipantsToTask');
    });

    Route::controller(ParticipantController::class)->group(function () {
        Route::get('participants', 'getParticipants')->name('participants.getParticipants');
        Route::post('participants', 'addParticipants')->name('participants.addParticipants');
        Route::put('participants/{id}', 'updateParticipants')->name('participants.updateParticipants');
        Route::get('participants/{id}', 'getParticipant')->name('participants.getParticipant');
        Route::delete('participants/{id}', 'deleteParticipants')->name('participants.deleteParticipants');
    });
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});
