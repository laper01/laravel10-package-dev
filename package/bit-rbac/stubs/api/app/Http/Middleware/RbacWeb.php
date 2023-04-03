<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RbacWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission = 0)
    {

        $segmetURL = $request->segments();
        $add =config('rbacBinAddress.add');
        // cek module yang di akses
        $mod = Module::withRowNumber()->where('name', $segmetURL[0])->first();
        if ($mod === null) {
            // return abort(404);
            $msg['data'] = null;
            $msg['meta'] = [
                "status" => "fail",
                "message" => "Not Found."
            ];
            return abort(response()->json($msg, 404));
        } else {
            // ambil code acess module from  table group
            $group = Auth::user()->group;
            if ($group->module_access_code & $add[$mod->row_number]) {

                if ($permission) {
                    $permissionName = [
                        'view' => 1,
                        'create' => 2,
                        'edit' => 4,
                        'delete' => 8,
                    ];
                    $rolePermission = Role::where('group_id', $group->id)->where('module_id', $mod->id)->first()->permision;

                    if ($rolePermission & $permissionName[$permission]) {
                        return $next($request);
                    } else {

                        $msg['data'] = null;
                        $msg['meta'] = [
                            "status" => "fail",
                            "message" => "Sory Permission denided."
                        ];
                        return abort(response()->json($msg, 401));
                    }
                } else {
                    return $next($request);
                }
            } else {

                $msg['data'] = null;
                $msg['meta'] = [
                    "status" => "fail",
                    "message" => "Forbidden. Permission denied."
                ];
                return abort(response()->json($msg, 401));
            }
        }
        return $next($request);
    }
}
