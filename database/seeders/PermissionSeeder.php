<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'admin',
            'admin.access',
            'admin.create',
            'admin.delete',
            'admin.edit',
            'admin.show',
            'conversation',
            'conversation.access',
            'conversation.create',
            'conversation.delete',
            'conversation.edit',
            'conversation.show',
            'notification',
            'notification.access',
            'notification.create',
            'notification.delete',
            'notification.edit',
            'notification.show',
            'order',
            'order.access',
            'order.create',
            'order.delete',
            'order.edit',
            'order.show',
            'payment',
            'payment.access',
            'payment.create',
            'payment.delete',
            'payment.edit',
            'payment.show',
            'product',
            'product.access',
            'product.create',
            'product.delete',
            'product.edit',
            'product.show',
            'subscription',
            'subscription.access',
            'subscription.create',
            'subscription.delete',
            'subscription.edit',
            'subscription.show',
            'ticket',
            'ticket.access',
            'ticket.create',
            'ticket.delete',
            'ticket.edit',
            'ticket.show',
            'transaction',
            'transaction.access',
            'transaction.create',
            'transaction.delete',
            'transaction.edit',
            'transaction.show',
            'viewTelescope',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        // gets all permissions via Gate::before rule; see app/Providers/AppServiceProvider.php
        Role::create(['name' => 'Super']);

        $adminRole = Role::create(['name' => 'Admin']);

        $adminPermissions = [
            'admin',
            'admin.access',
            'admin.create',
            'admin.delete',
            'admin.edit',
            'admin.show',
        ];

        $roles = [$adminRole];
        $permissions = [$adminPermissions];

        foreach ($roles as $role) {
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
