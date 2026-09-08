<?php

namespace App\Http\Controllers\Admin\Trust;

use App\Http\Requests\Admin\Trust\{StorePermissionRequest, UpdatePermissionRequest};
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission; // استخدام موديل Spatie
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::when($request->search, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('guard_name', 'LIKE', "%{$request->search}%"); // Guard بدل table
            });
        })->paginate();

        return view('admin.trust.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trust.permissions.create');
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        Permission::create($request->validated());
        return redirect()->route('permissions.index')->with('success', __('Permission created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.trust.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return redirect()->route('permissions.index')->with('success', __('Permission updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['success' => true, 'message' => __('Deleted Successfully')]);
    }
}