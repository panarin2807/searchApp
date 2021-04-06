<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prefix;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::where('type', 0)->simplePaginate(10, ['*'], 'student');
        return view('admin.user.index', ['students' => $students]);
    }

    public function getPersonel()
    {
        $teachers = User::where('type', 1)->simplePaginate(10, ['*'], 'teacher');
        return view('admin.user.personel', compact('teachers'));
    }

    public function getAdmin()
    {
        $admins = User::where('type', 2)->simplePaginate(10);
        return view('admin.user.admin', compact('admins'));
    }

    public function fetch_student(Request $request)
    {
        // $teacher = User::where('type', 1)->simplePaginate(10, ['*'], 'teacher');
        if ($request->ajax()) {
            $key = $request->get('query');

            if ($key == '') {
                $students = DB::table('users as u')
                    ->select('u.id', 'u.fname', 'u.lname', 'u.email', 'p.name', 'u.status')
                    ->join('prefixes as p', 'u.prefix_id', '=', 'p.id')
                    ->where('u.type', 0)
                    ->simplePaginate(10, ['*'], 'student');
            } else {
                $key = str_replace(' ', '%', $key);
                $students = DB::table('users as u')
                    ->select('u.id', 'u.fname', 'u.lname', 'u.email', 'p.name', 'u.status')
                    ->join('prefixes as p', 'u.prefix_id', '=', 'p.id')
                    ->where('u.id', 'like', '%' . $key . '%')
                    ->orWhere('u.fname', 'like', '%' . $key . '%')
                    ->orWhere('u.lname', 'like', '%' . $key . '%')
                    ->orWhere('u.username', 'like', '%' . $key . '%')
                    ->orWhere('u.email', 'like', '%' . $key . '%')
                    ->where('u.type', 0)
                    ->simplePaginate(10, ['*'], 'student');
            }
            $link = false;
            // return view('admin.user.index', ['students' => $students, 'teachers' => $teacher, 'link' => $link])->render();
            return view('admin.user.student_data', compact('students', 'link'))->render();
        }
    }

    public function showImport()
    {
        //return back()->with('status','wowza');
        return view('admin.user.import');
    }

    // public function import()
    // {
    //     Excel::import(new UsersImport, request()->file('file'));

    //     return back()->with('status', 'บันทึกข้อมูลสำเร็จ');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = UserType::all();
        return view('admin.user.create', ['prefixes' => Prefix::all(), 'types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = new User();

        $username = $request->get('username');

        $usernameWithoutDash = str_replace('-', '', $username);

        $password = substr($usernameWithoutDash, -6);

        $type = $request->get('type') ?? 0;

        $user->prefix_id = $request->get('prefix');
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->email = $request->get('email');
        $user->username = $username;
        $user->type = $type;
        if ($type == 2) {
            $user->password = Hash::make($request->get('password'));
        } else {
            $user->password = Hash::make(
                $password
            );
        }

        $message = '';

        if ($user->save()) {
            $message = 'เพิ่มข้อมูลสำเร็จ';
        } else {
            $message = 'เพิ่มข้อมูลล้มเหลว โปรดลองใหม่ภายหลัง';
        }

        return back()->with('status', $message);
    }

    protected function validator(array $data)
    {
        $message = [
            'fname.required' => 'กรุณาระบุชื่อจริง',
            'lname.required' => 'กรุณาระบุนามสกุล',
            'email.required' => 'กรุณาระบุ E-mail',
            'email.email' => 'กรุณากรอก E-mail ให้ถูกต้อง',
            'username.required' => 'กรุณาระบุ Username',
            'username.min' => 'รหัสนักศึกษาต้องมีความยาว 11 ตัวอักษร',
            'username.max' => 'รหัสนักศึกษาต้องมีความยาว 11 ตัวอักษร',
        ];

        if ($data['type'] == 0) {
            return Validator::make($data, [
                'prefix' => ['required'],
                'fname' => ['required', 'string', 'max:100'],
                'lname' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'username' => [
                    'required', 'string', 'min:11', 'max:11', 'unique:users',
                    function ($attr, $value, $fail) {
                        $splited = explode('-', $value);
                        if (count($splited) != 2) {
                            $fail('กรุณาระบุ Username ให้ถูกต้อง');
                        } elseif (!ctype_digit($splited[0]) || !ctype_digit($splited[1])) {
                            $fail('กรุณาระบุ Username ให้ถูกต้อง');
                        }
                    }
                ],
                //'password' => ['required', 'string', 'min:6', 'confirmed'],
            ], $message);
        } elseif ($data['type'] == 1) {
            return Validator::make($data, [
                'prefix' => ['required'],
                'fname' => ['required', 'string', 'max:100'],
                'lname' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'username' => ['required', 'string', 'min:6', 'max:100', 'unique:users'],
                //'password' => ['required', 'string', 'min:6', 'confirmed'],
            ], $message);
        } else {
            return Validator::make($data, [
                'prefix' => ['required'],
                'fname' => ['required', 'string', 'max:100'],
                'lname' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'username' => ['required', 'string', 'min:6', 'max:100', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],
            ], $message);
        }
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
        //return view('admin.user.index');
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
        return view('admin.user.edit', ['prefixes' => Prefix::all(), 'user' => User::findOrFail($id), 'types' => UserType::where('type', '!=', 2)->get()]);
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

        // dd($request->get('type'));

        if ($request->filled('password')) {
            $request->validate([
                'prefix' => 'required',
                'fname' => 'required|string|max:100',
                'lname' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $id,
                'username' => 'required|string|min:6|max:100|unique:users,username,' . $id,
                'password' => 'required|string|min:6|confirmed',
            ]);
        } else {
            $request->validate([
                'prefix' => 'required',
                'fname' => 'required|string|max:100',
                'lname' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $id,
                'username' => 'required|string|min:6|max:100|unique:users,username,' . $id,
            ]);
        }

        $user = User::find($id);

        $user->prefix_id = $request->get('prefix');
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->type = $request->get('type') ?? 0;
        if ($request->filled('password'))
            $user->password = Hash::make(
                $request->get('password')
            );

        $message = '';

        if ($user->save()) {
            $message = 'แก้ไขข้อมูลสำเร็จ';
        } else {
            $message = 'แก้ไขข้อมูลล้มเหลว โปรดลองใหม่ภายหลัง';
        }

        return back()->with('status', $message);
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
        $user = User::find($id);
        $user->status = !$user->status;
        $message = '';

        if ($user->save()) {
            $message = 'แก้ไขข้อมูล Username : ' . $user->username . ' เรียบร้อย';
        } else {
            $message = 'แก้ไขข้อมูลล้มเหลว โปรดลองใหม่ภายหลัง';
        }
        return back()->with('status', $message);
    }
}
