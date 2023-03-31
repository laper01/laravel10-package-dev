<?php

namespace Danova\BitRbac\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Auth\Group;
use App\Models\Auth\Module;
use App\Models\Auth\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = Auth::user()->group;

        if ($group->id == 1) {
            $msg['data'] = [
                'group' => Group::orderBy('id', 'ASC')->get()
                // 'group'=>Group::where('id','>',$group->id)->orderBy('id','ASC')->get()
            ];
            $msg['meta'] = [
                "status" => "success",
                "code" => 200,
                "message" => null
            ];
            return json_encode($msg);
        } else {
            // return view('group.index')->with([
            //     'title' => "Group",
            //     'config' => ConfigTemplate::getConfig(),
            //     'group' => Group::where('id', ">", Auth::user()->group->id)->get()
            // ]);
            $msg['data'] = [
                'group' => Group::where('id', ">", Auth::user()->group->id)->get()
            ];
            $msg['meta'] = [
                "status" => "success",
                "code" => 200,
                "message" => null
            ];
            return json_encode($msg);
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $modulOnRole = DB::table('roles')
            ->leftJoin('role_access_modules', 'roles.id', '=', 'role_access_modules.role_id')
            ->leftJoin('modules', 'modules.id', '=', 'role_access_modules.module_id')
            ->where('role_id', $role->id)
            ->get();

        return view('role.show')->with([
            'title' => "Modul Access",
            'user' => Auth::user(),
            'role' => $role,
            'modulsOnRole' => $modulOnRole,
            'modul' => Module::withRowNumber()->whereNotIn('id', $modulOnRole->pluck('id')->toArray())->get(),
            'add' => array(0, 1, 2, 4, 8, 16, 32, 64)
        ]);
    }

    public function roles(Group $group)
    {
        $modulOnRole = DB::table('groups')
            ->leftJoin('roles', 'groups.id', '=', 'roles.group_id')
            ->leftJoin('modules', 'modules.id', '=', 'roles.module_id')
            ->select('modules.*', 'roles.id as role_id', 'roles.permision', 'roles.group_id')
            ->where('group_id', $group->id)
            ->get();
        // with no root concept
        $module = Module::all();
        // wtih root concept
        // $module = DB::table('roles')
        // ->leftJoin('modules', 'modules.id', '=', 'roles.module_id')
        // ->select('modules.*','roles.id as role_id','roles.permision','roles.group_id')
        // ->where('group_id', $group->id-1)->where('permision','>',0)
        // ->get();


        // code di bawah = rbac hanya bisa di manage oleh developer

        // $module = DB::table('roles')
        // ->leftJoin('modules', 'modules.id', '=', 'roles.module_id')
        // ->select('modules.*','roles.id as role_id','roles.permision','roles.group_id')
        // ->where('name','<>','group')->where('group_id', $group->id-1)->where('permision','>',0)
        // ->get();

        // dd($modulOnRole);
        $msg['data']['moduleOnRole'] = $modulOnRole;
        $msg['data']['module'] = $module;
        // $msg['data']['module'] = Module::withRowNumber()->whereNotIn('id', $modulOnRole->pluck('id')->toArray())->get();
        $msg['meta'] = [
            "status" => "success",
            "code" => 200,
            "message" => null
        ];
        return json_encode($msg);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        dd($role);
    }
}
