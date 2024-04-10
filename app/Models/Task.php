<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $connection = 'mysql';

    public function Projects()
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
