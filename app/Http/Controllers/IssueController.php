<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IssueController extends Controller
{
    public function Index($project_id = null)
    {
        $project = [];
        if ($project_id) {
            $project = Project::leftjoin('staff', 'project.staff_id', 'staff.id')
                ->join('avatar', 'project.avatar_id', 'avatar.id')
                ->where('project.id', $project_id)
                ->first();
            if (!$project) {
                abort(404);
            }
        }
        return view('pages.issues', compact('project', 'project_id'));
    }
    public function Table(Request $request)
    {
        $data = [];
        $sql = "select 
                issue.id,
                issue.number,
                issue_type.name as type,
                project.code,
                issue.title,
                issue.reporter_id,
                issue.handler_id,
                handler.first_name as first_name_handler, 
                handler.last_name as last_name_handler,
                color_handler.name as color_handler,       
                reporter.first_name as first_name_reporter, 
                reporter.last_name as last_name_reporter,
                color_reporter.name as color_reporter,        
                priority.name as priority,
                priority.path as path_priority,
                issue_state.name as state,
                issue_state.background_color as background_color_state,
                issue_state.text_color as text_color_state,
                resolution.name as resolution,
                issue.creation_date,
                issue.last_update,
                issue.expiration_date
                from issue 
                inner join project on project.id = issue.project_id 
                left join staff as reporter on reporter.id = issue.reporter_id 
                left join color as color_reporter on color_reporter.id = reporter.color_id 

                left join staff as handler on handler.id = issue.handler_id 
                left join color as color_handler on color_handler.id = handler.color_id
                inner join issue_state on issue_state.id = issue.issue_state_id 
                inner join priority on priority.id = issue.priority_id 
                inner join issue_type on issue_type.id = issue.issue_type_id 
                left join resolution on resolution.id = issue.resolution_id";
        if ($request->project_id) {
            $sql .=  " where project.id = $request->project_id";
        }

        $issues =   DB::select(DB::raw($sql));

        foreach ($issues as $key => $value) {


            if ($value->handler_id) {
                $handlerAbrev = strtoupper(substr($value->first_name_handler, 0, 1) . '' . substr($value->last_name_handler, 0, 1));
                $handler = "<div class='user-card text-nowrap'>
                            <div class='user-avatar xs bg-$value->color_handler'>
                                <span>$handlerAbrev</span>
                            </div>
                            <div class=''>
                                <span class='tb-lead ml-2'>$value->first_name_handler $value->last_name_handler</span>
                            </div>
                        </div>";
            } else {
                $handler = "<div class='user-card text-nowrap'>
                                <img  style='max-width:17%' src='/images/default/sin-asignar.svg'>
                                <div class=''>
                                    <span class='tb-lead ml-2'>Sin asignar</span>
                                </div>
                            </div>";
            }

  
            if ($value->reporter_id) {
                $reporterrAbrev = strtoupper(substr($value->first_name_reporter, 0, 1) . '' . substr($value->last_name_reporter, 0, 1));
                $reporter = "<div class='user-card text-nowrap'>
                                <div class='user-avatar xs bg-$value->color_reporter'>
                                    <span>$reporterrAbrev</span>
                                </div>
                                <div class=''>
                                    <span class='tb-lead ml-2'>$value->first_name_reporter $value->last_name_reporter</span>
                                </div>
                            </div>";
            }else{
                $reporter = "<div class='user-card text-nowrap'>
                                <img  style='max-width:17%' src='/images/default/sin-asignar.svg'>
                                <div class=''>
                                    <span class='tb-lead ml-2'>Sin asignar</span>
                                </div>
                            </div>";
            }

            

            array_push($data,    [
                'type' =>  $value->type,
                'code' => "<p class='text-nowrap'> $value->code-$value->number</p>",
                'title' => "<p class='text-nowrap'> $value->title</p>",
                'handler' =>  $handler,
                'reporter' =>  $reporter,
                'priority' => "<img src='/files/priority/$value->path_priority'>",
                'state' => "<span style='border-radius: 14px; background: $value->background_color_state; color: $value->text_color_state;padding: 3px 8px;' class='text-nowrap'>$value->state</span>",
                'resolution' => $value->resolution,
                'creation_date' => ($value->creation_date) ?  "<p class='text-nowrap'> " . Carbon::parse($value->creation_date)->format('d-m-Y g:i A') . "</p>" : '',
                'last_update' => ($value->last_update) ?  "<p class='text-nowrap'> " . Carbon::parse($value->last_update)->format('d-m-Y g:i A') . "</p>" : '',
                'expiration_date' => ($value->expiration_date) ?   "<p class='text-nowrap'>" .  Carbon::parse($value->expiration_date)->format('d-m-Y') . " </p>" : '',
            ]);
        }

        return DataTables::of($data)
            ->rawColumns([
                'code',
                'title',
                'handler',
                'reporter',
                'priority',
                'state',
                'creation_date',
                'last_update',
                'expiration_date'
            ])
            ->make(true);
    }
}
