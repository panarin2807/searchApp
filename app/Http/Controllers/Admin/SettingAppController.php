<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Curriculum;
use App\Models\Group;
use App\Models\Prefix;
use Illuminate\Http\Request;

class SettingAppController extends Controller
{
    //
    public function index()
    {
        $prefixes = Prefix::all();
        $groups = Group::all();
        $curr = Curriculum::all();
        $configs = Config::all();
        return view('admin.app_config.index', ['prefixes' => $prefixes, 'groups' => $groups, 'curr' => $curr, 'configs' => $configs]);
    }
}
