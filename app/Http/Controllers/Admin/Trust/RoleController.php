<?php

namespace App\Http\Controllers\Admin\Trust;

use App\Http\Requests\Admin\Trust\{StoreRoleRequest, UpdateRoleRequest};
use App\Http\Controllers\Controller;
use App\Models\Trust\Permission;
use Illuminate\Http\Request;
use App\Models\Trust\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::when($request->search, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('display_name', 'LIKE', "%{$request->search}%");
            });
        })->paginate();

        return view('admin.trust.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('table');

        return view('admin.trust.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->safe()->except('permissions'));

        $role->syncPermissions($request->permissions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('table');

        return view('admin.trust.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->safe()->except('permissions'));

        $role->syncPermissions($request->permissions);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['success' => true, 'message' => __('Role Deleted Successfully')]);
    }
}
