<?php

namespace App\Http\Controllers\Api;

use App\Domain\Repos\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddParticipantToTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollectionResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
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
            return response()->json(TaskCollectionResource::collection($tasks));
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function createTask(StoreTaskRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('tasks', 'public');
                $data['image_path'] = $path;
            }

            $task = Task::create($data);

            return response()->json(new TaskResource($task), 201);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function updateTask(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('tasks', 'public');
        };

        $this->taskRepository->update($data, $id);

        return response()->json($this->taskRepository->get($id), 201);
    }


    public function getTask(int $id) : JsonResponse
    {
        try {
            $task = $this->taskRepository->get($id);
            return response()->json(new TaskResource($task), 200);
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

    public function addParticipantsToTask(AddParticipantToTaskRequest $request, int $taskId): JsonResponse
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(["error" => "Task not found"], 404);
        }

        // Преобразуем массив объектов [{ "id": 5 }, { "id": 6 }] в массив [5, 6]
        $participantIds = collect($request->validated()['ids'])->pluck('id')->toArray();

        if (empty($participantIds)) {
            return response()->json(["error" => "No valid participants found"], 400);
        }

        $task->participants()->attach($participantIds);

        return response()->json(["message" => "Added participants"], 201);
    }
}
