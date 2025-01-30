<?php

namespace App\Repos;

use App\Domain\Repos\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll()
    {
        return Task::all();
    }

    public function get(int $id)
    {
        return Task::with('participants')->findOrFail($id);
    }

    public function create(array $tasks)
    {
        $addedTasks = [];
        foreach ($tasks as $task) {
            $addedTasks[] = Task::create($task);
        }

        return $addedTasks;
    }

    public function update(array $updateTask, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return null;
        }

        $task->update([
            'name' => $updateTask['name'],
            'count' => $updateTask['count'],
        ]);

        return $task;
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return false;
        }

        $task->delete();
        return true;
    }
}
