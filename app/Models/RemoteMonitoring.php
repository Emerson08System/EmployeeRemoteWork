<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RemoteMonitoring extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }

    public function Tasks()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function Schedule()
    {
        return $this->belongsTo(RemoteSchedule::class, 'schedule_id', 'id');
    }

    public function Meetings()
    {
        return $this->belongsTo(RemoteMeetings::class, 'meeting_id', 'id');
    }
}
