<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    public function index()
    {
        $task = Task::get();

        return response()->json($task);
    }

    public function store(Request $request)
    {
        $tasks = [];

        foreach ($request->tasks as $task) {
            $tasks[] = Task::create([
                'name' => $task['name'],
                'count' => $task['count']
            ]);
        }

        return response()->json($tasks);
    }

    public function update(Request $request, int $id)
    {
        $task = Task::find($id);

        $task->update([
            'name' => $request->name,
            'count' => $request->count
        ]);

        return response()->json(Task::find($id), 200);
    }

    public function show(int $id)
    {
        return response()->json(Task::find($id), 200);
    }

    public function delete(int $id)
    {
        Task::find($id)->delete();

        return response()->json('deleted', 200);
    }
}
