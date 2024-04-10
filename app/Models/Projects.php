<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function Tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
