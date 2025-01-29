<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Task;
use Domain\Repos\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        try{
            $tasks = $this->taskRepository->allTasks();
            return response()->json($tasks);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) : JsonResponse
    {
        try {
            $task = $this->taskRepository->createTask($request);
            return response()->json($task, 201);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, int $id) : JsonResponse
    {
        try {
            $task = $this->taskRepository->updateTask($request, $id);
            return response()->json($task, 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function show(int $id) : JsonResponse
    {
        try {
            $task = $this->taskRepository->getTask($id);
            return response()->json($task, 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "Task not found"], 404);
        }
    }

    public function delete(int $id) : JsonResponse
    {
        try {
            $this->taskRepository->deleteTask($id);
            return response()->json(["message" => "Task deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function addParticipantsToTask(Request $request, int $taskId) : JsonResponse
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(["error" => "Task not found"], 404);
        }

        $participantIds = Participant::whereIn('id', $request->ids)->pluck('id');

        if ($participantIds->isEmpty()) {
            return response()->json(["error" => "No valid participants found"], 400);
        }

        $task->participants()->attach($participantIds);

        return response()->json(["message" => "Added participants"], 202);
    }
}
