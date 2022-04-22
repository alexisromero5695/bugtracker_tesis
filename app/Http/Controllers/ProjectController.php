<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function Index(Request $request)
    {
        return view('pages.projects');
    }
    public function Create(Request $request)
    {
        Project::create([
            'staff_id' => $request->staff,
            'avatar_id' => $request->avatar,
            'title' => $request->title,
            'code' => $request->code,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),
            'description' => $request->description,
        ]);
        return 'success';
    }
    public function Table(Request $request)
    {
        $data = [];
        $projects =  Project::leftjoin('staff', 'project.staff_id', 'staff.id')
            ->join('avatar', 'project.avatar_id', 'avatar.id')
            ->get();
        foreach ($projects as $key => $value) {
            array_push($data,    [
                'title' => "<div class='d-flex align-items-center'>
                                <div class='user-avatar sq mr-1'>
                                        <img  src='/files/avatar/{$value->path}'>
                                </div>{$value->title}
                            </div>",
                'code' => $value->code,
                'staff' =>  "$value->first_name $value->last_name",
                'start_date' => ($value->start_date) ? Carbon::parse($value->start_date)->format('d-m-Y') : '',
            ]);
        }

        return DataTables::of($data)
            ->rawColumns(['title'])
            ->make(true);
    }
}
