<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayOffPermissionNames=[
            'أضافة مستخدم','عرض مستخدم',' حذف مستخدم','أضافة صلاحية ','تعديل صلاحية',
            'حذف صلاحية', 'أضافة مشريات','عرض مشريات','تعديل مشريات','حذف مشريات',' تفاصيل مشريات',
            'أضافة اصناف', 'حذف اصناف','تعديل اصناف','اضافة وحدات','عرض حساب عميل','أضافة حساب عميل',
            'عرض حساب مورد','اضافة حساب مورد','عرض الضبط العام','الضبط العام','اضافة مبيعات',
            'عرض مبيعات','عرض تقرير','اضافة مخزن','تعديل مخزن','سند قبض','اضافة مرتجع مشتريات','سند صرف'
        ];
        $permissions=collect($arrayOffPermissionNames)->map(function($permission){
            return ['name'=>$permission, 'guard_name'=>'web'];
        });
        Permission::insert($permissions->toArray());

        $role=Role::create(['name'=>'admin'])->givePermissionTo($arrayOffPermissionNames);
        $role = Role::create(['name' => 'sales-person'])->givePermissionTo(['اضافة مبيعات','عرض مبيعات','عرض تقرير']);
       
    }
}
