<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RbacApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,  $permission = 0)
    {
        // return abort(404);
        $segmetURL = $request->segments();
        $add = config('rbacBinAddress.add');
        // cek module yang di akses
        $mod = Module::withRowNumber()->where('name', $segmetURL[1])->first();
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
                        'edite' => 4,
                        'delete' => 8,
                    ];
                    $rolePermission = Role::where('group_id', $group->id)->where('module_id', $mod->id)->first()->permision;

                    if ($rolePermission & $permissionName[$permission]) {
                        return $next($request);
                    } else {
                        $msg['data'] = null;
                        $msg['meta'] = [
                            "status" => "fail",
                            "message" => "Forbidden. Permission denied."
                        ];
                        return abort(response()->json($msg, 403));
                    }
                } else {
                    return $next($request);
                }
            } else {
                $msg['data'] = null;
                $msg['meta'] = [
                    "status" => "fail",
                    "message" => "Canot Access."
                ];
                return abort(response()->json($msg, 403));
            }
        }
        return $next($request);
    }
}
