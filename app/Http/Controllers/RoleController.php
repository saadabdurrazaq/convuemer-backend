<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:View Roles', ['only' => ['index']]);
        $this->middleware('permission:Create Role', ['only' => ['store']]);
        $this->middleware('permission:Update Role', ['only' => ['update']]);
    }

    function check($permissionName) {
        $staff = Auth::guard('staff-api')->user();
        
        if (! $staff->hasPermissionTo($permissionName)) { // $staff->hasRole('Super User')
            abort(403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role is exist!',
            'staff' => $staff->hasPermissionTo($permissionName)
        ]);
     }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = $request->items ?? 5;
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->get(); // ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')->
        $roles = Role::orderBy('id', 'DESC')->paginate($items);

        return response()->json([
			'roles' => $roles,
            'role_permissions' => $rolePermissions,
		], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return response()->json([
			'permissions' => $permissions,
		], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permissions'));

        return response()->json([
            'message' => 'Role successfully created!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();


        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();

        return response()->json([
			'roles' => $role,
            'permissions' => $permissions,
            'role_permissions' => $rolePermissions
		], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->save();

        $role->syncPermissions($request->get('permissionsId'));

        return response()->json([ 
            'success' => true,
            'message' => 'Role successfully updated!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role successfully deleted',
        ]);
    }
}
