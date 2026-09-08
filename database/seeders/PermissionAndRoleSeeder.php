<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionAndRoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // الفئات
            ['name' => 'create_categories', 'display_name' => 'إنشاء الفئات', 'table' => 'categories'],
            ['name' => 'show_categories', 'display_name' => 'عرض الفئات', 'table' => 'categories'],
            ['name' => 'edit_categories', 'display_name' => 'تعديل الفئات', 'table' => 'categories'],
            ['name' => 'delete_categories', 'display_name' => 'حذف الفئات', 'table' => 'categories'],

            // المنتجات
            ['name' => 'create_products', 'display_name' => 'إنشاء المنتجات', 'table' => 'products'],
            ['name' => 'show_products', 'display_name' => 'عرض المنتجات', 'table' => 'products'],
            ['name' => 'edit_products', 'display_name' => 'تعديل المنتجات', 'table' => 'products'],
            ['name' => 'delete_products', 'display_name' => 'حذف المنتجات', 'table' => 'products'],

            // المستخدمين
            ['name' => 'create_users', 'display_name' => 'إنشاء المستخدمين', 'table' => 'users'],
            ['name' => 'show_users', 'display_name' => 'عرض المستخدمين', 'table' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'تعديل المستخدمين', 'table' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'حذف المستخدمين', 'table' => 'users'],

            // الطلبات
            ['name' => 'create_orders', 'display_name' => 'إنشاء الطلبات', 'table' => 'orders'],
            ['name' => 'show_orders', 'display_name' => 'عرض الطلبات', 'table' => 'orders'],
            ['name' => 'edit_orders', 'display_name' => 'تعديل الطلبات', 'table' => 'orders'],
            ['name' => 'delete_orders', 'display_name' => 'حذف الطلبات', 'table' => 'orders'],

           


            // المخزون
            ['name' => 'create_stocks', 'display_name' => 'إنشاء المخزون', 'table' => 'stocks'],
            ['name' => 'show_stocks', 'display_name' => 'عرض المخزون', 'table' => 'stocks'],
            ['name' => 'edit_stocks', 'display_name' => 'تعديل المخزون', 'table' => 'stocks'],
            ['name' => 'delete_stocks', 'display_name' => 'حذف المخزون', 'table' => 'stocks'],

            // العملاء
            ['name' => 'create_customers', 'display_name' => 'إنشاء العملاء', 'table' => 'customers'],
            ['name' => 'show_customers', 'display_name' => 'عرض العملاء', 'table' => 'customers'],
            ['name' => 'edit_customers', 'display_name' => 'تعديل العملاء', 'table' => 'customers'],
            ['name' => 'delete_customers', 'display_name' => 'حذف العملاء', 'table' => 'customers'],

            // الإعدادات
            ['name' => 'create_settings', 'display_name' => 'إنشاء الإعدادات', 'table' => 'settings'],
            ['name' => 'show_settings', 'display_name' => 'عرض الإعدادات', 'table' => 'settings'],
            ['name' => 'edit_settings', 'display_name' => 'تعديل الإعدادات', 'table' => 'settings'],
            ['name' => 'delete_settings', 'display_name' => 'حذف الإعدادات', 'table' => 'settings'],

            // التقارير
            ['name' => 'create_reports', 'display_name' => 'إنشاء التقارير', 'table' => 'reports'],
            ['name' => 'show_reports', 'display_name' => 'عرض التقارير', 'table' => 'reports'],
            ['name' => 'edit_reports', 'display_name' => 'تعديل التقارير', 'table' => 'reports'],
            ['name' => 'delete_reports', 'display_name' => 'حذف التقارير', 'table' => 'reports'],


           
            // الصلاحيات
            ['name' => 'create_permissions', 'display_name' => 'إنشاء الصلاحيات', 'table' => 'permissions'],
            ['name' => 'show_permissions', 'display_name' => 'عرض الصلاحيات', 'table' => 'permissions'],
            ['name' => 'edit_permissions', 'display_name' => 'تعديل الصلاحيات', 'table' => 'permissions'],
            ['name' => 'delete_permissions', 'display_name' => 'حذف الصلاحيات', 'table' => 'permissions'],
           
            
        ];

        // إنشاء الصلاحيات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'guard_name' => 'web',
            ], [
                'display_name' => $permission['display_name'],
                'table' => $permission['table'],
            ]);
        }

        $permissionNames = array_column($permissions, 'name');

        $UserPermissions = array_filter($permissionNames, function ($perm) {
            return
                str_starts_with($perm, 'create_orders') ||   // إنشاء الطلبات
                str_starts_with($perm, 'show_orders')   ||   // عرض الطلبات
                str_starts_with($perm, 'create_expenses');   // إضافة مصاريف فقط
        });

        // صلاحيات الأدمن = كل شيء ما عدا الحذف
        $adminPermissions = array_filter($permissionNames, fn($perm) => !str_starts_with($perm, 'delete_'));

        // إنشاء الأدوار
        $user = Role::firstOrCreate(
            ['name' => 'user', 'guard_name' => 'web'],
            ['display_name' => 'مستخدم']
        );
        $user->syncPermissions($UserPermissions);

        $admin = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['display_name' => 'أدمن']
        );
        $admin->syncPermissions($adminPermissions);

        $superAdmin = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'web'],
            ['display_name' => 'سوبر أدمن']
        );
        $superAdmin->syncPermissions($permissionNames);

        // إنشاء المستخدمين وربطهم بالأدوار
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'diaa', 'password' => bcrypt('password123')]
        );
        $adminUser->assignRole('Admin');

        $User = User::firstOrCreate(
            ['email' => 'User@gmail.com'],
            ['name' => 'ahmed', 'password' => bcrypt('password123')]
        );
        $User->assignRole('user');
        $User->syncPermissions($UserPermissions);

        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            ['name' => 'sabah', 'password' => bcrypt('password123')]
        );
        $superAdminUser->assignRole('Super Admin');
        $superAdminUser->syncPermissions($permissionNames);
    }
}
// This seeder creates permissions and roles for a Laravel application using Spatie's Permission package.