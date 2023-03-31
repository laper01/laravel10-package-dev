<?php

namespace Danova\BitRbac\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\ConfigTemplate;
use App\Models\Auth\Group;
use App\Models\Auth\Module;
use App\Models\Auth\Role;
use Illuminate\Http\Request;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul.index')->with([
            'title' => "Modul",
            'config' => ConfigTemplate::getConfig(),
            'moduls' => Module::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul.add')->with([
            'title' => "Edit Modul",
            'config' => ConfigTemplate::getConfig()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|alpha_dash|unique:modules,name',
            'display_name' => 'required',
            'permission' => 'required'
        ]);
        $mybit = _makeBit(8);
        // dd(bindec(_replaceBit($mybit, $validate['permission'])));
        Module::create([
            'name' => strtolower($validate['name']),
            'display_name' => $validate['display_name'],
            'allow_permision' => bindec(_replaceBit($mybit, $validate['permission'])),
            'author' => 'Yusuf',
            'edited' => 'Yusuf',
            'folder' => strtolower($validate['name'])
        ]);
        return redirect('/module');
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
    public function edit(Module $module)
    {
        return view('modul.edite')->with([
            'title' => "Edit Modul",
            'config' => ConfigTemplate::getConfig(),
            'module' => $module
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        dd($request->permission);

        // if (isset(request()->post()['permisions'])) {
        //     $validate = $request->validate([
        //         'permisions' => 'required'
        //     ]);
        //     // dd($validate);
        //     $ram = Role::where('group_id', $group->id)->where('module_id', $mid)->first();
        //     // update code
        //     $mybit = _makeBit(8);
        //     $ram->permision = bindec(_replaceBit($mybit, $validate['permisions']));
        //     $ram->save();
        // } else {
        //     Role::where('group_id', $group->id)->where('module_id', $mid)->delete();
        //     $mybit = _makeBitHIGH(63);

        //     $index = Module::withRowNumber()->where("id", $mid)->first()->row_number;
        //     // echo $index;
        //     // echo "<br>";
        //     // // die;
        //     // echo $mybit;
        //     // echo "<br>";

        //     // $group->module_access_code |=bindec(_replaceBit($mybit,$validate['accesses']));
        //     // $group->save();
        //     $hasil = bindec(substr_replace($mybit, '0', 63 - $index, 1));

        //     // echo $hasil;
        //     // echo "<br>";
        //     // echo 31 & $hasil;
        //     // die;

        //     $group->module_access_code &= $hasil;
        //     $group->save();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::withRowNumber()->where('id', $id)->first();
        $groups = Group::all();

        foreach ($groups as $group) {
            $group->module_access_code = _removeBit($group->module_access_code, $module->row_number);
            $group->save();
        }
        Role::where('module_id', $module->id)->delete();
        $module->delete();
        return redirect()->back();
    }
}
