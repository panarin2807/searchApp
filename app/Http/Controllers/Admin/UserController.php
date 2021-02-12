<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prefix;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::where('type', 0)->get();
        $teacher = User::where('type', 1)->get();
        return view('admin.user.index', ['students' => $students, 'teachers' => $teacher]);
    }

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

        $user->prefix_id = $request->get('prefix');
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->type = $request->get('type') ?? 0;
        $user->password = Hash::make(
            $request->get('password')
        );

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
        return Validator::make($data, [
            'prefix' => ['required'],
            'fname' => ['required', 'string', 'max:100'],
            'lname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'username' => ['required', 'string', 'min:6', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
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
