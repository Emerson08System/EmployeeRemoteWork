<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Task;
use App\Models\RemoteMeetings;
use App\Models\RemoteMonitoring;
use App\Models\RemoteRequest;
use App\Models\RemoteSchedule;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class EmployeeTrackingController extends Controller
{
    public function Dashboard()
    {
        $RemoteRequest = RemoteRequest::whereNull('deleted_at')->count();
        $Projects = Projects::whereNull('deleted_at')->count();
        $RemoteMeetings = RemoteMeetings::whereNull('deleted_at')->count();
        $RemoteMonitoring = RemoteMonitoring::whereNull('deleted_at')->count();

        $RemoteMonitoringDisplay = RemoteMonitoring::with('Employee','Tasks','Meetings','Schedule')->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        $projectStats = Projects::selectRaw('YEAR(projects.updated_at) as year, MONTH(projects.updated_at) as month, COUNT(*) as projects_completed')
            ->whereNull('projects.deleted_at')
            ->where('status', 'Complete')
            ->groupBy('year', 'month')
            ->get();

        $TaskStats = Task::selectRaw('YEAR(tasks.updated_at) as year, MONTH(tasks.updated_at) as month, COUNT(*) as tasks_completed')
            ->whereNull('tasks.deleted_at')
            ->where('task_status', 'Completed')
            ->groupBy('year', 'month')
            ->get();

        return view('EmployeeTracking.dashboard',compact('RemoteRequest','Projects','RemoteMeetings','RemoteMonitoring','RemoteMonitoringDisplay','projectStats','TaskStats'));
    }

    public function RemoteRequest()
    {
        $remote = RemoteRequest::with('Employee')->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        $employees = Employee::whereNull('deleted_at')->get();

        return view('EmployeeTracking.remoterequest',compact('remote','employees'));
    }

    public function RemoteRequestStore(Request $request)
    {
        // dd($request->all());
        RemoteRequest::create([
            'emp_id' => $request->employee_id,
            'total_score' => $request->total_score,
            'request_date' => $request->request_date,
            'request_reason' => $request->request_reason,
            'jobrole_suitability' => $request->jobrole_suitability,
            'performance_accountability' => $request->performance_accountability,
            'technological_readiness' => $request->technological_readiness,
            'work_environment' => $request->work_environment,
            'communication_skills' => $request->communication_skills,
            'flexibility_adaptability' => $request->flexibility_adaptability,
            'health_wellbeing' => $request->health_wellbeing,
            'organizational_needs' => $request->organizational_needs,
            'legal_compliance' => $request->legal_compliance,
            'status' => 'Pending',
        ]);

        $notification = [
            'success' => 'Remote Request Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.request')
        ->with($notification);
    }

    public function RemoteRequestUpdate(Request $request)
    {

        $item_id = $request->item_id;
        $RemoteRequest = RemoteRequest::findOrFail($item_id);
        $RemoteRequest->update([
            'total_score' => $request->total_score,
            'request_date' => $request->request_date,
            'request_reason' => $request->request_reason,
            'jobrole_suitability' => $request->jobrole_suitability,
            'performance_accountability' => $request->performance_accountability,
            'technological_readiness' => $request->technological_readiness,
            'work_environment' => $request->work_environment,
            'communication_skills' => $request->communication_skills,
            'flexibility_adaptability' => $request->flexibility_adaptability,
            'health_wellbeing' => $request->health_wellbeing,
            'organizational_needs' => $request->organizational_needs,
            'legal_compliance' => $request->legal_compliance,
            'status' => $request->status,
        ]);

        $notification = [
            'success' => 'Remote Request Update Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.request')
        ->with($notification);
    }

    public function RemoteRequestGet($id){
        $transferGET = RemoteRequest::with('Employee')->findOrFail($id);
        return response()->json($transferGET);
    }


    public function Monitoring()
    {
        $employees = Employee::get();
        $tasks = Task::get();
        $meetings = RemoteMeetings::get();

        $RemoteMonitoring = RemoteMonitoring::with('Employee','Tasks','Meetings')->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('EmployeeTracking.monitoring',compact('RemoteMonitoring','employees','tasks','meetings'));
    }

    public function Schedule()
    {

        $schedule = RemoteSchedule::whereNull('deleted_at')->latest('updated_at')->get();

        return view('EmployeeTracking.schedule',compact('schedule'));
    }

    public function RemoteEmployees()
    {
        $employees = Employee::get();
        $tasks = Task::get();
        $meetings = RemoteMeetings::get();
        $schedules = RemoteSchedule::get();

        $RemoteMonitoring = RemoteMonitoring::with('Employee','Tasks','Meetings','Schedule')->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('EmployeeTracking.employeeremote',compact('RemoteMonitoring','employees','tasks','meetings','schedules'));
    }


    public function RemoteEmployeesStore(Request $request)
    {
        RemoteMonitoring::create([
            'emp_id' => $request->employee_id,
            'schedule_id' => $request->schedule_id,
            'task_id' => $request->task_id,
            'meeting_id' => $request->meeting_id,
        ]);

        $notification = [
            'success' => 'Remote Meetings Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.employees')
        ->with($notification);
    }

    public function RemoteEmployeesUpdate(Request $request)
    {
        $item_id = $request->item_id;
        $RemoteMonitoring = RemoteMonitoring::findOrFail($item_id);
        $RemoteMonitoring->update([
            'schedule_id' => $request->schedule_id,
            'task_id' => $request->task_id,
            'meeting_id' => $request->meeting_id,
            'status' => $request->status,
        ]);

        $notification = [
            'success' => 'Remote Meetings Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.employees')
        ->with($notification);
    }


    public function Projects()
    {
        $projects = Projects::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('EmployeeTracking.projects', compact('projects'));
    }

    public function ProjectsStore(Request $request)
    {
        Projects::create([
            'project_name' => $request->project_name,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'date_start' => $request->date_start,
            'progress' => $request->progress,
            'description' => $request->description,
            'status' => 'Open',
        ]);

        $notification = [
            'success' => 'Remote Meetings Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.projects')
        ->with($notification);
    }

    public function ProjectsUpdate(Request $request)
    {

        $item_id = $request->item_id;
        $Projects = Projects::findOrFail($item_id);
        $Projects->update([
            'project_name' => $request->project_name,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'date_start' => $request->date_start,
            'progress' => $request->progress,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        $notification = [
            'success' => 'Project Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.projects')
        ->with($notification);
    }



    public function Task()
    {
        $tasks = Task::with('Projects','Employee')->latest('updated_at')->get();

        // $projects = Projects::doesntHave('tasks')->get();
        $projects = Projects::get();
        $employees = Employee::get();

        return view('EmployeeTracking.task',compact('tasks','projects','employees'));
    }

    public function TaskStore(Request $request)
    {
        dd($request->all());
        Task::create([
            'project_id' => $request->project_id,
            'emp_id' => $request->employee_id,
            'task_name' => $request->task_name,
            'due_date' => $request->due_date,
            'task_progress' => $request->task_progress,
            'task_status' => 'Open',
        ]);

        $notification = [
            'success' => 'Tasks Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('remote.task')->with($notification);
    }

    public function TaskUpdate(Request $request)
    {

        $item_id = $request->item_id;
        $Projects = Task::findOrFail($item_id);
        $Projects->update([
            'task_name' => $request->task_name,
            'due_date' => $request->due_date,
            'task_progress' => $request->task_progress,
            'task_status' => $request->task_status,
        ]);

        $notification = [
            'success' => 'Tasks Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.task')
        ->with($notification);
    }

    public function Meetings()
    {
        $meetings = RemoteMeetings::with('Employee')->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        $employees = Employee::get();

        return view('EmployeeTracking.meetings',compact('meetings','employees'));
    }

    public function MeetingsStore(Request $request)
    {
        RemoteMeetings::create([
            'title' => $request->title,
            'organizer_id' => $request->organizer_id,
            'meeting_date' => $request->meeting_date,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'location' => $request->location,
            'description' => $request->description,
            'meeting_link' => $request->meeting_links,
            'attendies' => $request->attendies,
            'status' => 'Pending',
        ]);


        $notification = [
            'success' => 'Remote Meetings Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.meetings')
        ->with($notification);
    }

    public function MeetingsUpdate(Request $request)
    {

        $item_id = $request->item_id;

        $RemoteMeetings = RemoteMeetings::findOrFail($item_id);

        $RemoteMeetings->update([
            'title' => $request->title,
            'organizer_id' => $request->organizer_id,
            'meeting_date' => $request->meeting_date,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'location' => $request->location,
            'description' => $request->description,
            'meeting_link' => $request->meeting_links,
            'attendies' => $request->attendies,
            'status' => $request->status,
        ]);

        $notification = [
            'success' => 'Remote Meetings Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
        ->route('remote.meetings')
        ->with($notification);
    }





}

