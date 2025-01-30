<?php

namespace App\Domain\Repos;

use App\Models\Task;
use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function getAll();
    public function get(int $id);
    public function create(array $task);
    public function update(array $task, int $id);
    public function delete(int $id);
}
