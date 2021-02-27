<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //
    public function importExportView()
    {
        return view('admin.user.import');
    }

    public function import()
    {
        try {
            Excel::import(new UsersImport, request()->file('file'));
            return back()->with('status', 'เพิ่มข้อมูลสำเร็จ');
        } catch (Exception $e) {
            return back()->with('error', 'เพิ่มข้อมูลไม่สำเร็จ');
        }
    }
}
