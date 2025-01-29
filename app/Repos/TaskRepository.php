<?php

namespace App\Repos;

use App\Models\Task;
use Domain\Repos\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskRepository implements TaskRepositoryInterface
{
    public function allTasks()
    {
        return Task::all();
    }

    public function getTask(int $id)
    {
        return Task::with('participants')->findOrFail($id);
    }

    public function createTask(Request $request)
    {
        $tasks = [];

        foreach ($request->tasks as $task) {
            $tasks[] = Task::create([
                'name' => $task['name'],
                'count' => $task['count']
            ]);
        }

        return $tasks;
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return null;
        }

        $task->update([
            'name' => $request->name,
            'count' => $request->count
        ]);

        return $task;
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return false;
        }

        $task->delete();
        return true;
    }
}
