<?php

use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TaskApiController::class)->group(function () {
    Route::get('tasks', 'index')->name('tasks.index');
    Route::post('tasks', 'store')->name('tasks.store');
    Route::put('tasks/{id}', 'update')->name('tasks.update');
    Route::get('tasks/{id}', 'show')->name('tasks.show');
    Route::delete('tasks/{id}', 'delete')->name('tasks.delete');
    Route::post('tasks/{id}/participants', 'addParticipantsToTask')->name('tasks.addParticipantsToTask');
});

Route::controller(ParticipantController::class)->group(function () {
    Route::get('participants', 'getParticipants')->name('participants.getParticipants');
    Route::post('participants', 'addParticipants')->name('participants.addParticipants');
    Route::put('participants/{id}', 'updateParticipants')->name('participants.updateParticipants');
    Route::get('participants/{id}', 'getParticipant')->name('participants.getParticipant');
    Route::delete('participants/{id}', 'deleteParticipants')->name('participants.deleteParticipants');
});
