<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\File;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'due_date', 'status', 'created_by', 'updated_by',
    ];

    public $sortable = [
        'due_date', 'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_task');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
