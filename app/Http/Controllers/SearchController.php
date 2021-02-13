<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Project;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SearchController extends Controller
{
    //
    public function getSearch(Request $request)
    {

        $rule = [
            'keyword' => 'required|string',
            'curr' => 'required',
            'group' => 'required',
            'start' => 'required',
            'end' => 'required',
            'column' => 'required',
        ];
        $message = [
            'keyword.required' => 'กรุณาระบุคำค้นหา',
            'curr.required' => 'กรุณาเลือกหลักสูตร',
            'group.required' => 'กรุณาเลือกกลุ่ม',
            'start.required' => 'กรุณาระบุปีเริ่มต้น',
            'end.required' => 'กรุณาระบุปีสิ้นสุด',
            'column.required' => 'กรุณาเลือก Field ที่ต้องการค้นหา'
        ];

        $request->validate($rule, $message);

        $group = $request->get('group'); //where in
        $curr = $request->get('curr'); // where in
        $start = $request->get('start'); //where between
        $end = $request->get('end'); //where between
        $keyword = $request->get('keyword'); //where like
        $column = $request->get('column'); //

        //return back()->with('status','Column : '.json_encode($column));

        //$projects = Project::where('status', 1)->get();
        $currs = Curriculum::where('status', 1)->get();
        $groups = Group::where('status', 1)->get();
        $fields = ['name_th' => 'ชื่อภาษาไทย', 'name_en' => 'ชื่อภาษาอังกฤษ', 'abstract' => 'บทคัดย่อ'];
        $projects = Project::where('status', 1)
            ->whereBetween('year', [$start, $end])
            ->whereIn('group_id', $group)
            ->whereIn('curricula_id', $curr)
            ->where(function ($q) use ($column, $keyword) {
                foreach ($column as $col) {
                    $q->orWhere($col, 'like', '%' . $keyword . '%');
                }
            })->get();

        //return back()->with('sql',$projects);

        return view('home', compact('projects', 'currs', 'groups', 'fields'));
    }
}
