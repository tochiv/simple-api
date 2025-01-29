<?php

namespace Domain\Repos;

use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function allTasks();
    public function getTask(int $id);
    public function createTask(Request $request);
    public function updateTask(Request $request, int $id);
    public function deleteTask(int $id);
}
