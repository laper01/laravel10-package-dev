<?php

namespace Danova\BitRbac\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Auth\Group;
use App\Models\Auth\Module;
use App\Models\Auth\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Group $group, $module)
    {
        $module=Module::withRowNumber()->where('id', $module)->first();
        $validate = $request->validate([
            'permissionCode' => 'required',
            'status'=>'required'
        ]);

        $role=Role::where('module_id',$module->id)->where('group_id',$group->id)->first();
        if($role){
            if($group->id==1 && $validate['permissionCode']==1 && !$validate['status']){
                $msg['meta'] = [
                    "status" => "fail",
                    "code"=>200,
                    "message" => "Canot Change Permision."
                ];
            }else{
                if($validate['status']){
                    $role->permision |= $validate['permissionCode'];
                }else{
                    $role->permision &= ~$validate['permissionCode'];
                }
                if($role->save()){
                    // update berhasil

                    $msg['meta'] = [
                        "status" => "success",
                        "code"=>200,
                        "message" => "Permision Changed."
                    ];
                }
                if($role->permision<=0){
                    $group->module_access_code=0;
                    $group->save();
                }else{
                    $group->module_access_code|=config('rbacBinAddress.add')[$module->row_number];
                    $group->save();

                }
            }

        }else{
            $isCreated=Role::create([
                'permision'=>$validate['permissionCode'],
                'module_id'=>$module->id,
                'group_id'=>$group->id
            ]);
            if($isCreated){
                // update berhasil
                $msg['meta'] = [
                    "status" => "success",
                    "code"=>200,
                    "message" => "Permision Added."
                ];

                $group->module_access_code|=config('rbacBinAddress.add')[$module->row_number];
                $group->save();
            }

        }


        // responses
        $msg['data']=null;

        return json_encode($msg);
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
    public function show(Group $group)
    {
        // $modulOnRole=DB::table('groups')
        // ->leftJoin('roles', 'groups.id', '=', 'roles.group_id')
        // ->leftJoin('modules', 'modules.id', '=', 'roles.module_id')
        // ->where('group_id',$group->id)
        // ->get();
        // // dd($modulOnRole);

        // return view('role.show')->with([
        //     'title'=>"Group",
        //     'group'=>$group,
        //     'modulsOnRole'=>$modulOnRole,
        //     'modul'=>Module::withRowNumber()->whereNotIn('id',$modulOnRole->pluck('id')->toArray())->get(),
        //     'add'=>array(0,1,2,4,8,16,32,64)
        // ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        $validate = $request->validate([
            'permissionCode' => 'required',
            'status'=>'required'
        ]);
        // grup developer biar ndak bisa di hapus
        if($role->group_id==1 && $validate['permissionCode']==1 && !$validate['status'] && false){
            $msg['meta'] = [
                "status" => "fail",
                "code"=>200,
                "message" => "Canot Change Permision."
            ];
        }else{
            if($validate['status']){
                $role->permision |= $validate['permissionCode'];
            }else{
                $role->permision &= ~$validate['permissionCode'];
            }

            // responsesx
            if($role->save()){
                // update berhasil
                $group=Group::find($role->group_id);
                $module=Module::withRowNumber()->where('id', $role->module_id)->first();
                if($role->permision<=0){
                    $group->module_access_code &= ~config('rbacBinAddress.add')[$module->row_number];
                    $group->save();
                }else{
                    $group->module_access_code |= config('rbacBinAddress.add')[$module->row_number];
                    $group->save();
                }
                $msg['meta'] = [
                    "status" => "success",
                    "code"=>200,
                    "message" => "Permission updated."
                ];

            }else{
                $msg['meta'] = [
                    "status" => "fail",
                    "code"=>200,
                    "message" => "Permission Canot Update."
                ];
            }
        }
        $msg['data']=null;
        return json_encode($msg);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
