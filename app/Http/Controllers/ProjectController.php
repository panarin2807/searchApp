<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Project as ReflectionProject;

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
        $projects = Project::where('status', 1)->simplePaginate(5);
        //$groups = Group::findOrFail(4));
        return view('admin.project.index', compact('projects'));
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
        $curr = Curriculum::where('status', 1)->get();
        $groups = Group::where('status', 1)->get();
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
            'curr' => 'required',
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

        $configs = Config::where('status', 1)->get();

        $request->validate($rules, $message);

        $students = $request->get('student');

        $teachers = $request->get('teacher');

        $projectId = DB::table('projects')->insertGetId([
            'name_th' => $request->get('name_th'),
            'name_en' => $request->get('name_en'),
            'year' => $request->get('year'),
            'advisor_joint' => $request->input('select_teacher_joint'),
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
                DB::table('project_files')->insert([
                    'project_id' => $projectId,
                    'config_id' => $value->id,
                ]);
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
        $project = Project::findOrFail($id);
        $students = User::where('type', 0)->get();
        $teachers = User::where('type', 1)->get();
        $configs = Config::where('status', 1)->get();
        $curr = Curriculum::where('status', 1)->get();
        $groups = Group::where('status', 1)->get();
        return view('admin.project.edit', compact('project', 'students', 'teachers', 'configs', 'curr', 'groups'));
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
        $rules = [
            'name_th' => 'required|string',
            'name_en' => 'required|string',
            'student' => 'required',
            'teacher' => 'required',
            'year' => 'required|string|min:4|max:4',
            'abstract' => 'required|string',
            'group' => 'required',
            'curr' => 'required',
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

        $configs = Config::where('status', 1)->get();

        $files = DB::table('project_files')->where('project_id', $id)->get();

        if (count($files) > 0) {
            $year = explode('/', $files[0]->value)[1];
        } else {
            $year = date('Y');
        }

        foreach ($configs as $value) {
            if ($request->hasFile('file_' . $value->id)) {
                $file = $request->file('file_' . $value->id);
                $path = $file->storeAs('file/' . $year . '/' . $id, $value->description . '.pdf');
                DB::table('project_files')->where([
                    ['project_id', $id],
                    ['config_id', $value->id]
                ])->update([
                    'value' => $path,
                ]);
            }
        }

        $data = array(
            'name_th' => $request->get('name_th'),
            'name_en' => $request->get('name_en'),
            'year' => $request->get('year'),
            'abstract' => $request->get('abstract'),
            'group_id' => $request->get('group'),
            'curricula_id' => $request->get('curr'),
        );

        if ($request->get('teacher_joint') != null) {
            $data['advisor_joint'] = $request->input('select_teacher_joint');
        }

        DB::table('projects')->where('id', $id)->update($data);

        $students = $request->get('student');

        $teachers = $request->get('teacher');

        $users = array_merge($students, $teachers);

        DB::table('project_relas')->where('project_id', $id)->whereNotIn('user_id', $users)->delete();

        foreach ($students as $key => $value) {
            DB::table('project_relas')->upsert([
                'user_id' => $value,
                'project_id' => $id
            ], 'user_project_index');
        }

        foreach ($teachers as $key => $value) {
            DB::table('project_relas')->upsert([
                'user_id' => $value,
                'project_id' => $id
            ], 'user_project_index');
        }

        return redirect()->action([ProjectController::class, 'index'])->with('status', 'แก้ไขโครงงานสำเร็จ');
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
        $project = Project::findOrFail($id);
        $files = DB::table('project_files')->where('project_id', $project->id)->get();
        $path = explode('/', $files[0]->value);
        Storage::deleteDirectory($path[0] . '/' . $path[1] . '/' . $path[2]);
        DB::table('project_files')->where('project_id', $project->id)->delete();
        DB::table('project_relas')->where('project_id', $project->id)->delete();
        $project->delete();
        return back()->with('status', 'ลบโครงงานสำเร็จ');
    }
}
