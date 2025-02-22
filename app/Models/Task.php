<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];
    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'task_participants', 'task_id', 'participant_id');
    }
    protected $fillable = [
        'name',
        'count',
        'image_path'
    ];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
