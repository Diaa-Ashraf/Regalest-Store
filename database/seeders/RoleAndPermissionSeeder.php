<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions with Arabic display names
        $permissions = [
            'view-dashboard'   => 'عرض لوحة التحكم',
            'view-analytics'   => 'عرض التحليلات والإحصائيات',
            'manage-products'  => 'إدارة المنتجات والمخزون',
            'manage-categories'=> 'إدارة الأقسام والتصنيفات',
            'manage-orders'    => 'إدارة وتتبع الطلبات',
            'manage-bundles'   => 'إدارة العروض المجمعة',
            'manage-deals'     => 'إدارة التخفيضات والعروض',
            'manage-banners'   => 'إدارة الإعلانات والبانرات',
            'manage-settings'  => 'إدارة إعدادات المتجر',
            'manage-users'     => 'إدارة المستخدمين والأدوار',
        ];

        foreach ($permissions as $name => $displayName) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['display_name' => $displayName]
            );
        }

        // 1. Super Admin Role (has all permissions)
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web'],
            ['display_name' => 'المدير العام']
        );
        $superAdminRole->syncPermissions(Permission::all());

        // 2. Admin Role (manager permissions)
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['display_name' => 'مدير النظام']
        );
        $adminRole->syncPermissions([
            'view-dashboard',
            'view-analytics',
            'manage-products',
            'manage-categories',
            'manage-orders',
            'manage-bundles',
            'manage-deals',
            'manage-banners',
        ]);

        // 3. Customer Role
        Role::firstOrCreate(
            ['name' => 'customer', 'guard_name' => 'web'],
            ['display_name' => 'عميل المتجر']
        );
    }
}
