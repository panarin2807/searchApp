<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currs = Curriculum::where('status', 1)->get();
        $groups = Group::where('status', 1)->get();
        //$projects = Project::where('status', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $fields = ['name_th' => 'ชื่อภาษาไทย', 'name_en' => 'ชื่อภาษาอังกฤษ', 'abstract' => 'บทคัดย่อ', 'advisor_joint' => 'อาจารย์ที่ปรึกษา'];
        return view('home', ['projects' => [], 'currs' => $currs, 'groups' => $groups, 'fields' => $fields, 'isInit' => true]);
    }

    public function search(Request $request)
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

        $currs = Curriculum::where('status', 1)->get();
        $groups = Group::where('status', 1)->get();
        $fields = ['name_th' => 'ชื่อภาษาไทย', 'name_en' => 'ชื่อภาษาอังกฤษ', 'abstract' => 'บทคัดย่อ', 'advisor_joint' => 'อาจารย์ที่ปรึกษา'];
        $projects = Project::where(function ($q) use ($column, $keyword, $group, $curr, $start, $end) {
            $q->where('status', 1);
            foreach ($column as $col) {
                $q->orWhere($col, 'like', '%' . $keyword . '%');
            }
            $q->whereBetween('year', [$start, $end]);
            $q->whereIn('group_id', $group);
            $q->whereIn('curricula_id', $curr);
        })->get();

        return view('home', compact('projects', 'currs', 'groups', 'fields'));
    }
}
