<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\Menurole;

class RolesController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->get();
        return view('listRoles.index', array(
            'roles' => $roles,
        ));
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();
        
        return redirect()->route('roles.create');
    }

}
