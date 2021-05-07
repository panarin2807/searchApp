<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SearchController extends Controller
{
    //
    public function getSearch(Request $request)
    {

        $rule = [
            'keyword' => 'required|string',
            // 'curr' => 'required',
            // 'group' => 'required',
            // 'start' => 'required',
            // 'end' => 'required',
            // 'column' => 'required',
        ];
        $message = [
            'keyword.required' => 'กรุณาระบุคำค้นหา',
            // 'curr.required' => 'กรุณาเลือกหลักสูตร',
            // 'group.required' => 'กรุณาเลือกกลุ่ม',
            // 'start.required' => 'กรุณาระบุปีเริ่มต้น',
            // 'end.required' => 'กรุณาระบุปีสิ้นสุด',
            // 'column.required' => 'กรุณาเลือก Field ที่ต้องการค้นหา'
        ];

        //$request->validate($rule, $message);

        $group = $request->get('group'); //where in
        $curr = $request->get('curr'); // where in
        $start = $request->get('start'); //where between
        $end = $request->get('end'); //where between
        $keyword = $request->get('keyword'); //where like
        $column = $request->get('column'); //

        //$projects = Project::where('status', 1)->get();
        $currs = Curriculum::where('status', 1)->get();
        $groups = Group::where('status', 1)->get();
        $fields = ['name_th' => 'ชื่อโครงงานภาษาไทย', 'name_en' => 'ชื่อโครงงานภาษาอังกฤษ', 'abstract' => 'บทคัดย่อ', 'advisor_joint' => 'อาจารย์ที่ปรึกษา'];

        if ($group == null) {
            $group = [];
            foreach ($groups as $item) {
                array_push($group, $item->id);
            }
        }

        if ($curr == null) {
            $curr = [];
            foreach ($currs as $item) {
                array_push($curr, $item->id);
            }
        }

        if ($column == null) {
            $column = [];
            foreach ($fields as $key => $val) {
                array_push($column, $key);
            }
        }

        if ($start == null) $start = '1997';
        else $start -= 543;
        if ($end == null) $end = date('Y');
        else $end -= 543;

        // dd($start,$end);

        $teacher = User::where([
            ['type', 1],
            ['status', 1]
        ])->where(function ($q) use ($keyword) {
            $q->where('fname', 'like', '%' . $keyword . '%')->orWhere('lname', 'like', '%' . $keyword . '%');
        })->first();

        $projectsWithoutTeacher = Project::with('groups')
            ->whereHas('groups', function ($q) use ($group) {
                $q->whereIn('group_id', $group);
            })
            ->where('status', 1)
            ->whereBetween('year', [$start, $end])
            ->whereIn('curricula_id', $curr)
            ->where(function ($q) use ($column, $keyword) {
                foreach ($column as $col) {
                    $q->orWhere($col, 'like', '%' . $keyword . '%');
                }
            })
            ->get();

        $isInit = false;

        if ($teacher != null) {
            //return back()->with('status','teacher id : '.$teacher->id);
            $projectWithTeacher = Project::with('groups')
                ->whereHas('groups', function ($q) use ($group) {
                    $q->whereIn('group_id', $group);
                })
                ->where('status', 1)
                ->whereBetween('year', [$start, $end])
                ->whereIn('curricula_id', $curr)
                ->whereHas('relas', function ($q) use ($teacher) {
                    $q->where('project_relas.user_id', $teacher->id);
                })
                ->get();
            $projects = $projectsWithoutTeacher->merge($projectWithTeacher);
            return view('home', compact('projects', 'currs', 'groups', 'fields', 'isInit'));
        } else {
            $projects = $projectsWithoutTeacher;
            return view('home', compact('projects', 'currs', 'groups', 'fields', 'isInit'));
        }
    }
}
