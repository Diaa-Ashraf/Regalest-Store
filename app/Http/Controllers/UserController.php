<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage-users'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }
    public function index(): \Illuminate\View\View
    {
        $users = User::query()
            ->select(['id', 'name', 'email', 'phone', 'is_active', 'created_at'])
            ->with('roles')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // جيبي كل الـ Roles من قاعدة البيانات
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // إعطاء الـ Role للـ User
        $user->assignRole($request->role);


        return redirect()->route('users.index')->with('success', __('user created successfully!'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // جيبي كل الـ Roles
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }


        $user->update($data);

        $user->syncRoles([$request->role]); // syncRoles بيشيل أي Roles قديمة ويضيف الجديد

        return redirect()->route('users.index')->with('success', __('user updated successfully!'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', __('user deleted successfully!'));
    }
}
