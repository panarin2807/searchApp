<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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
        // $projects = Project::where('status', 1)->simplePaginate(5);
        // $keyword = 'asdasd';
        // $projects2 = Project::where('status', 1)
        //     ->where('name_th', 'like', '%' . $keyword . '%')
        //     ->orWhere([
        //         ['name_en', 'like', '%' . $keyword . '%'],
        //         ['year', 'like', '%' . $keyword . '%'],
        //     ])
        //     ->orWhereHas('users', function ($query) use ($keyword) {
        //         $query->where('fname', 'like', '%' . $keyword . '%');
        //         $query->orWhere('lname', 'like', '%' . $keyword . '%');
        //     })
        //     ->simplePaginate(5);
        //$groups = Group::findOrFail(4));
        return view('admin.project.index');
        // return view('admin.project.index', compact('projects', 'projects2'));
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        if (is_numeric($keyword)) {
            $keyword -= 543;
        }

        if ($request->ajax()) {
            $output = "";
            if ($keyword == '') {
                $projects = Project::where('status', 1)
                    ->where('name_th', 'like', '%' . $keyword . '%')
                    ->orWhere('name_en', 'like', '%' . $keyword . '%')
                    ->orWhere('year', 'like', '%' . $keyword . '%')
                    ->orWhereHas('users', function ($query) use ($keyword) {
                        $query->where('fname', 'like', '%' . $keyword . '%');
                        $query->orWhere('lname', 'like', '%' . $keyword . '%');
                    })
                    ->simplePaginate(10);
            } else {
                $projects = Project::where('status', 1)
                    ->where('name_th', 'like', '%' . $keyword . '%')
                    ->orWhere('name_en', 'like', '%' . $keyword . '%')
                    ->orWhere('year', 'like', '%' . $keyword . '%')
                    ->orWhereHas('users', function ($query) use ($keyword) {
                        $query->where('fname', 'like', '%' . $keyword . '%');
                        $query->orWhere('lname', 'like', '%' . $keyword . '%');
                    })
                    ->get();
            }

            foreach ($projects as $item) {
                $students = [];
                $teachers = [];
                foreach ($item->relas as $rela) {
                    if ($rela->user->type == 0) {
                        array_push($students, $rela->user);
                    } else {
                        array_push($teachers, $rela->user);
                    }
                }
                $studentCount = count($students);
                $teacherCount = count($teachers);
                $output .= '
                <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-body row">
                        <a href="' . route('project.edit', $item->id) . '" style="text-decoration: none;">
                            <div class="col-md-12">
                                ' . $item->name_th . '
                            </div>
                            <div class="col-md-12">
                                ' . $item->name_en . '
                            </div>
                        </a>
                        <div class="col-md-12">
                            <span>โดย : </span>';
                foreach ($students as $key => $val) {
                    if ($key == $studentCount - 1) {
                        $output .= '<span>' . $val->fname . ' ' . $val->lname . '</span></div>';
                    } else {
                        $output .= '<span>' . $val->fname . ' ' . $val->lname . ',' . '</span>';
                    }
                }
                $output .= '
                <div class="col-md-12">
                <span>อาจารย์ที่ปรึกษาหลัก : </span>
                ';
                foreach ($teachers as $key => $val) {
                    if ($key == $teacherCount - 1) {
                        $output .= '<span>' . $val->fname . ' ' . $val->lname . '</span></div>';
                    } else {
                        $output .= '<span>' . $val->fname . ' ' . $val->lname . ',' . '</span>';
                    }
                }
                $output .= '<div class="col-md-12"> ปี : ' . $item->year + 543 . '</div></div>';
                $output .= '
                <div class="row justify-content-center">
                    <form action="' . route('project.destroy', $item) . '" method="post">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class="btn" type="submit"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div></div></div>
                ';
            }

            return Response($output);
        }
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

        $year = $request->get('year');

        $projectId = DB::table('projects')->insertGetId([
            'name_th' => $request->get('name_th'),
            'name_en' => $request->get('name_en'),
            'year' => $year,
            'advisor_joint' => $request->input('select_teacher_joint'),
            'abstract' => $request->get('abstract'),
            'group_id' => $request->get('group'),
            'curricula_id' => $request->get('curr'),
        ]);

        $path = '';

        foreach ($configs as $value) {
            if ($request->hasFile('file_' . $value->id)) {

                $file = $request->file('file_' . $value->id);
                $name = $value->description . '.pdf';
                $path = 'file/' . $year . '/' . $projectId . '/' . $name;
                Storage::disk('s3')->put($path, file_get_contents($file), 'public-read');
                DB::table('project_files')->insert([
                    'project_id' => $projectId,
                    'config_id' => $value->id,
                    'value' => $path,
                ]);

                // $file = $request->file('file_' . $value->id);
                // $path = $file->storeAs('file/' . $year . '/' . $projectId, $value->description . '.pdf');
                // DB::table('project_files')->insert([
                //     'project_id' => $projectId,
                //     'config_id' => $value->id,
                //     'value' => $path,
                // ]);
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

        $year = $request->get('year');

        foreach ($configs as $value) {
            if ($request->hasFile('file_' . $value->id)) {

                $file = $request->file('file_' . $value->id);
                $name = $value->description . '.pdf';
                $path = 'file/' . $year . '/' . $id . '/' . $name;
                Storage::disk('s3')->put($path, file_get_contents($file), 'public-read');
                DB::table('project_files')->where([
                    ['project_id', $id],
                    ['config_id', $value->id]
                ])->update([
                    'value' => $path,
                ]);

                // $file = $request->file('file_' . $value->id);
                // $path = $file->storeAs('file/' . $year . '/' . $id, $value->description . '.pdf');
                // DB::table('project_files')->where([
                //     ['project_id', $id],
                //     ['config_id', $value->id]
                // ])->update([
                //     'value' => $path,
                // ]);
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
        //$path = explode('/', $files[0]->value);
        //Storage::deleteDirectory($path[0] . '/' . $path[1] . '/' . $path[2]);
        DB::table('project_files')->where('project_id', $project->id)->delete();
        DB::table('project_relas')->where('project_id', $project->id)->delete();
        $project->delete();
        return back()->with('status', 'ลบโครงงานสำเร็จ');
    }
}
