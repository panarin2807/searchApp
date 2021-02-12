<?php

namespace App\Http\Controllers;

use App\Models\Prefix;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('setting', ['prefixes' => Prefix::all(),'user' => User::findOrFail($id), 'types' => UserType::where('type', '!=', 2)->get()]);
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
                'password' => 'required|string|min:6|confirmed',
            ]);
        } else {
            $request->validate([
                'prefix' => 'required',
                'fname' => 'required|string|max:100',
                'lname' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);
        }

        $user = User::find($id);

        $user->prefix_id = $request->get('prefix');
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->email = $request->get('email');
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
    }
}
