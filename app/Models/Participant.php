<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_participants', 'participant_id', 'task_id');
    }
    protected $fillable = [
        'name'
    ];
}
