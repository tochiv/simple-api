<?php

use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TaskApiController::class)->group(function () {
    Route::get('tasks', 'getTasks')->name('tasks.getTasks');
    Route::post('tasks', 'createTasks')->name('tasks.createTasks');
    Route::put('tasks/{id}', 'updateTask')->name('tasks.updateTask');
    Route::get('tasks/{id}', 'getTask')->name('tasks.getTask');
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
