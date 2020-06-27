<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $all_permissions = Permission::all();
        $admin_permissions = $all_permissions->filter(function ($permission) {
            return $permission->title != 'loan_application_create';
        });
        Role::findOrFail(1)->permissions()->sync($admin_permissions);
        $user_permissions = $all_permissions->filter(function ($permission) {
            return $permission->title == 'loan_application_access' || $permission->title == 'loan_application_create' || $permission->title == 'loan_application_show';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
        $analyst_cfo_permissions = $user_permissions->filter(function ($permission) {
            return $permission->title != 'loan_application_create';
        });
        Role::findOrFail(3)->permissions()->sync($analyst_cfo_permissions);
        Role::findOrFail(4)->permissions()->sync($analyst_cfo_permissions);
    }
}
