<?php

namespace App\Http\Controllers\Api;

use App\Domain\Repos\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasks(): JsonResponse
    {
        try{
            $tasks = $this->taskRepository->getAll();
            return response()->json($tasks);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function createTasks(Request $request) : JsonResponse
    {
        try {
            $task = $this->taskRepository->create($request);
            return response()->json($task, 201);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function updateTask(Request $request, int $id) : JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'required',
                'count' => 'required|integer|min:1|max:10000',
            ]);
            $task = $this->taskRepository->update($data, $id);
            return response()->json($task, 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getTask(int $id) : JsonResponse
    {
        try {
            $task = $this->taskRepository->get($id);
            return response()->json($task, 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "Task not found"], 404);
        }
    }

    public function deleteTask(int $id) : JsonResponse
    {
        try {
            $this->taskRepository->delete($id);
            return response()->json(["message" => "Task deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function addParticipantsToTask(Request $request, int $taskId): JsonResponse
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(["error" => "Task not found"], 404);
        }

        // Получаем только существующих участников
        $validParticipantIds = Participant::whereIn('id', $request->ids)->pluck('id');

        if ($validParticipantIds->isEmpty()) {
            return response()->json(["error" => "No valid participants found"], 400);
        }

        // Добавляем участников без дубликатов
        $task->participants()->syncWithoutDetaching($validParticipantIds);

        return response()->json(["message" => "Added participants"], 201);
    }
}
