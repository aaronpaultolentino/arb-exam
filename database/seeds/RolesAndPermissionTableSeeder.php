<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role = new Role([
            'name' => 'Administrator',
            'description' => 'Admin of the site',
        ]);

        $role->save();

        $role->permissions()->save(new Permission([
            'name' => 'Dashboard Module',
            'action' => 'access_dashboard',
        ]));

        $role->permissions()->save(new Permission([
            'name' => 'User Module',
            'action' => 'access_user',
        ]));


        $role->permissions()->save(new Permission([
            'name' => 'Expense Module',
            'action' => 'access_expense',
        ]));
        
        $role = new Role([
            'name' => 'User',
            'description' => 'Normal user of the site',
        ]);

        $role->save();

        $role->permissions()->save(new Permission([
            'name' => 'Expense Module',
            'action' => 'access_expense',
        ]));
    }
}
