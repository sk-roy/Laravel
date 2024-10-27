<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'color',
    ];

    protected $sortable = [
        'name',
    ];

    public function task() {        
        return $this->hasMany(Task::class, 'task_label');
    }
}
