<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groups = Group::simplePaginate(10);
        return view('admin.group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $actionRoute = route('admin.group.store');
        return view('admin.group.create', compact('actionRoute'));
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
        $rules = [
            'name' => 'required|string',
            'detail' => 'required|string',
        ];

        $message = [
            'name.required' => 'กรุณาระบุชื่อกลุ่ม',
            'detail.required' => 'กรุณาระบุรายละเอียดกลุ่ม',
        ];

        $request->validate($rules, $message);
        $group = new Group();
        $group->name = $request->get('name');
        $group->detail = $request->get('detail');
        $message = '';
        $status = 'status';

        if ($group->save()) {
            $message = 'เพิ่มข้อมูลกลุ่มสำเร็จ';
        } else {
            $message = 'เพิ่มข้อมูลกลุ่มล้มเหลว โปรดลองใหม่ภายหลัง';
            $status = 'error';
        }

        return redirect()->action([GroupController::class, 'index'])->with($status, $message);
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
        $group = Group::find($id);
        $actionRoute = route('admin.group.update', $group);
        return view('admin.group.edit', compact('group', 'actionRoute'));
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
            'name' => 'required|string',
            'detail' => 'required|string',
        ];

        $message = [
            'name.required' => 'กรุณาระบุชื่อกลุ่ม',
            'detail.required' => 'กรุณาระบุรายละเอียดกลุ่ม',
        ];

        $request->validate($rules, $message);
        $group = Group::find($id);
        $group->name = $request->get('name');
        $group->detail = $request->get('detail');
        $message = '';
        $status = 'status';

        if ($group->save()) {
            $message = 'แก้ไขข้อมูลกลุ่มสำเร็จ';
        } else {
            $message = 'แก้ไขข้อมูลกลุ่มล้มเหลว โปรดลองใหม่ภายหลัง';
            $status = 'error';
        }

        return redirect()->action([GroupController::class, 'index'])->with($status, $message);
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
        $group = Group::find($id);
        $group->status = !$group->status;
        $message = '';

        if ($group->save()) {
            $message = 'เปลี่ยนสถานะกลุ่ม : ' . $group->id . ' เรียบร้อย';
        } else {
            $message = 'เปลี่ยนสถานะกลุ่มล้มเหลว โปรดลองใหม่ภายหลัง';
        }
        return back()->with('status', $message);
    }
}
