<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::all();
        //$groups = Group::findOrFail(4));
        return view('project.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $students = User::where('type', 0)->get();
        $teachers = User::where('type', 1)->get();
        $configs = Config::where('status', 1)->get();
        $curr = Curriculum::all();
        $groups = Group::all();
        return view('project.create', ['students' => $students, 'teachers' => $teachers, 'configs' => $configs, 'curr' => $curr, 'groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name_th' => 'required|string',
            'name_en' => 'required|string',
            'student' => 'required',
            'teacher' => 'required',
            'year' => 'required|string|min:4|max:4',
            'abstract' => 'required|string',
            'group' => 'required',
            'curr' => 'required'
        ];

        $message = [
            'name_th.required' => 'กรุณาระบุชื่อภาษาไทย',
            'name_en.required' => 'กรุณาระบุชื่อภาษาอังกฤษ',
            'student.required' => 'กรุณาเลือกนักศึกษา',
            'teacher.required' => 'กรุณาเลือกอาจารย์',
            'year.*' => 'กรุณาเลือกปีการศึกษา',
            'abstract.required' => 'กรุณาเพิ่มบทคัดย่อ',
            'group.required' => 'กรุณาเลือกกลุ่ม',
            'curr.required' => 'กรุณาเลือกหลักสูตร',
        ];

        $request->validate($rules, $message);

        $students = $request->get('student');

        $teachers = $request->get('teacher');

        $configs = Config::where('status', 1)->get();

        $projectId = DB::table('projects')->insertGetId([
            'name_th' => $request->get('name_th'),
            'name_en' => $request->get('name_en'),
            'year' => $request->get('year'),
            'advisor_joint' => $request->get('select_teacher_joint'),
            'abstract' => $request->get('abstract'),
            'group_id' => $request->get('group'),
            'curricula_id' => $request->get('curr'),
        ]);

        $path = '';

        $year = date("Y");

        foreach ($configs as $value) {
            if ($request->hasFile('file_' . $value->id)) {
                $file = $request->file('file_' . $value->id);
                $path = $file->storeAs('file/' . $year . '/' . $projectId, $value->description . '.pdf');
                DB::table('project_files')->insert([
                    'project_id' => $projectId,
                    'config_id' => $value->id,
                    'value' => $path,
                ]);
            } else {
                return back()->with(['error' => 'เพิ่มโครงงานไม่สำเร็จ']);
            }
        }

        foreach ($students as $key => $value) {
            DB::table('project_relas')->insert([
                'user_id' => $value,
                'project_id' => $projectId
            ]);
        }

        foreach ($teachers as $key => $value) {
            DB::table('project_relas')->insert([
                'user_id' => $value,
                'project_id' => $projectId
            ]);
        }

        return back()->with(['status' => 'Path to file ' . $path]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $project = Project::findOrFail($id);
        //$groups = Group::findOrFail(4));
        return view('project.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
