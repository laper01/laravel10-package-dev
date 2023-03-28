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
        $add = array(
            0,
            1,
            2,
            4,
            8,
            16,
            32,
            64,
            128,
            256,
            512,
            1024,
            2048,
            4096,
            8192,
            16384,
            32768,
            65536,
            131072,
            262144,
            524288,
            1048576,
            2097152,
            4194304,
            8388608,
            16777216,
            33554432,
            67108864,
            134217728,
            268435456,
            536870912,
            1073741824,
            2147483648,
            4294967296,
            8589934592,
            17179869184,
            34359738368,
            68719476736,
            137438953472,
            274877906944,
            549755813888,
            1099511627776,
            2199023255552,
            4398046511104,
            8796093022208,
            17592186044416,
            35184372088832,
            70368744177664,
            140737488355328,
            281474976710656,
            562949953421312,
            1125899906842624,
            2251799813685248,
            4503599627370496,
            9007199254740992,
            18014398509481984,
            36028797018963968,
            72057594037927936,
            144115188075855872,
            288230376151711744,
            576460752303423488,
            1152921504606846976,
            2305843009213693952,
            4611686018427387904
        );
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
