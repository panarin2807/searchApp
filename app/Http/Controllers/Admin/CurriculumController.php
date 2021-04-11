<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currs = Curriculum::simplePaginate(10);
        return view('admin.curricular.index', compact('currs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $actionRoute = route('admin.curr.store');
        return view('admin.curricular.create', compact('actionRoute'));
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
        ];

        $message = [
            'name.required' => 'กรุณาระบุชื่อหลักสูตร',
        ];

        $request->validate($rules, $message);

        $curr = new Curriculum();
        $curr->name = $request->get('name');

        $message = '';
        $status = 'status';

        if ($curr->save()) {
            $message = 'เพิ่มข้อมูลหลักสูตรสำเร็จ';
        } else {
            $message = 'เพิ่มข้อมูลหลักสูตรล้มเหลว โปรดลองใหม่ภายหลัง';
            $status = 'error';
        }

        return redirect()->action([CurriculumController::class, 'index'])->with($status, $message);
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
        $curr = Curriculum::find($id);
        $actionRoute = route('admin.curr.update', $curr);
        return view('admin.curricular.edit', compact('curr', 'actionRoute'));
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
        ];

        $message = [
            'name.required' => 'กรุณาระบุชื่อหลักสูตร',
        ];

        $request->validate($rules, $message);

        $curr = Curriculum::find($id);
        $curr->name = $request->get('name');

        $message = '';
        $status = 'status';

        if ($curr->save()) {
            $message = 'แก้ไขข้อมูลหลักสูตรสำเร็จ';
        } else {
            $message = 'แก้ไขข้อมูลหลักสูตรล้มเหลว โปรดลองใหม่ภายหลัง';
            $status = 'error';
        }

        return redirect()->action([CurriculumController::class, 'index'])->with($status, $message);
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
        $curr = Curriculum::find($id);
        $curr->status = !$curr->status;

        $message = '';
        $status = 'status';

        if ($curr->save()) {
            $message = 'แก้ไขข้อมูลหลักสูตรสำเร็จ';
        } else {
            $message = 'แก้ไขข้อมูลหลักสูตรล้มเหลว โปรดลองใหม่ภายหลัง';
            $status = 'error';
        }
        return back()->with($status, $message);
    }
}
