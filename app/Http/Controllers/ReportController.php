<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function showGroupReport($year = '')
    {
        if ($year == '') $year = date('Y');

        $groups = Group::all();

        foreach ($groups as  $key => $val) {
            $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            $labels[] = 'หมวดหมู่ที่ ' . intval($key + 1);
            $groupName[] = $val->name;
            $data[] = count($val->projects->where('year', $year));
        }

        // $groups = DB::table('groups')
        //     ->select('groups.name as name', DB::raw('count(projects.id) as total'))
        //     ->leftJoin('projects', 'groups.id', '=', 'projects.group_id')
        //     ->groupBy('groups.name')
        //     ->get();

        // foreach ($groups as $key => $val) {
        //     $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        //     $labels[] = 'หมวดหมู่ที่ ' . intval($key + 1);
        //     $groupName[] = $val->name;
        //     $data[] = $val->total;
        // }

        $chart = new Chart;
        $chart->labels = $labels;
        $chart->dataset = $data;
        $chart->colours = $colours;
        $chart->name = $groupName;
        return view('reports.report_group', compact('chart', 'year'));
    }

    public function showTeacherReport($year = '')
    {
        if ($year == '') $year = date('Y');

        $groups = User::where('type', 1)->get();

        foreach ($groups as $key => $val) {
            $groupName[] = $val->prefix->name.$val->fname.' '.$val->lname;
            $data[] = count($val->projects->where('year', $year));
            $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            $labels[] = intval($key + 1);
        }

        // dd($groups);

        // $groups = DB::table('users')
        //     ->select(DB::raw('CONCAT(users.fname," ", users.lname) AS name'), DB::raw('count(project_relas.id) as total'))
        //     ->leftJoin('project_relas', 'users.id', '=', 'project_relas.user_id')
        //     ->where('users.type', 1)
        //     ->groupBy('name')
        //     ->get();

        // foreach ($groups as $key => $val) {
        //     $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        //     $labels[] = intval($key + 1);
        //     $groupName[] = $val->name;
        //     $data[] = $val->total;
        // }

        $chart = new Chart;
        $chart->labels = $labels;
        $chart->dataset = $data;
        $chart->colours = $colours;
        $chart->name = $groupName;
        return view('reports.report_teacher', compact('chart', 'year'));
    }
}
