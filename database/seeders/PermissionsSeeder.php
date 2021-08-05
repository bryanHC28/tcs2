<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions_array = [];
        array_push($permissions_array, Permission::create(['name' => 'create_products']));
        array_push($permissions_array, Permission::create(['name' => 'edit_products']));
        array_push($permissions_array, Permission::create(['name' => 'delete_products']));
       //Se cea un permiso a aparte para el cliente, 
        $viewCustomerPermission = Permission::create(['name' => 'view_products']);
       //Mete el permiso al array 
        array_push($permissions_array, $viewCustomerPermission);
        //Se crea el rol admin, y se le asigna el array
        $superAdminRole = Role::create(['name' => 'admin']);
        $superAdminRole->syncPermissions($permissions_array);
        $operativoRole = Role::create(['name' => 'operativo']);
        $operativoRole->syncPermissions($permissions_array);
        //Se crea el cliente y se le asigna el permiso
        $viewAmaRole = Role::create(['name' => 'Ama de llaves']);
        $viewAmaRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewCamaristaRole = Role::create(['name' => 'Camarista']);
        $viewCamaristaRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewCocineroRole = Role::create(['name' => 'Cocinero']);
        $viewCocineroRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewGerenciaRole = Role::create(['name' => 'Gerencia general']);
        $viewGerenciaRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewGuardiaRole = Role::create(['name' => 'Guardia ejecutiva']);
        $viewGuardiaRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewHuespedRole = Role::create(['name' => 'Huésped']);
        $viewHuespedRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewMantenimientoRole = Role::create(['name' => 'Mantenimiento']);
        $viewMantenimientoRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewOficinasRole = Role::create(['name' => 'Oficinas']);
        $viewOficinasRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewProveedorRole = Role::create(['name' => 'Proveedor']);
        $viewProveedorRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewRecepcionRole = Role::create(['name' => 'Recepción']);
        $viewRecepcionRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewRestauranteRole = Role::create(['name' => 'Restaurante']);
        $viewRestauranteRole->syncPermissions($viewCustomerPermission);
        //Se crea el cliente y se le asigna el permiso
        $viewSeguridadRole = Role::create(['name' => 'Seguridad']);
        $viewSeguridadRole->syncPermissions($viewCustomerPermission);

       
        $userSuperAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@tickets.com',
            'password' => Hash::make('password'),
        ]);

        $userSuperAdmin->assignRole('admin');

        $userOperativo = User::create([
            'name' => 'Operativo',
            'email' => 'operativo@tickets.com',
            'password' => Hash::make('password'),
        ]);

        $userOperativo->assignRole('operativo');

        $userCustomer = User::create([
            'name' => 'amadellaves',
            'email' => 'amadellaves@tickets.com',
            'password' => Hash::make('password'),
        ]);

        $userCustomer->assignRole('Ama de llaves');

   
    
    }
}
