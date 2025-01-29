<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function participants()
    {
        return $this->belongsToMany(Task::class, 'task_participants', 'task_id', 'participant_id');
    }
    protected $fillable = [
        'name',
        'count'
    ];
}
