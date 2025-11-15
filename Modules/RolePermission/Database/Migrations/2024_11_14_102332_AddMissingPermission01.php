<?php

use Illuminate\Database\Migrations\Migration;

class AddMissingPermission01 extends Migration
{
    public function up()
    {

        $routes = [
            ['name' => 'Deduct', 'route' => 'offlinePayment.deduct', 'type' => 3, 'parent_route' => 'offlinePayment'],

            ['name' => 'Email Template Update', 'route' => 'updateEmailTemp', 'type' => 3, 'parent_route' => 'EmailTemp'],
            ['name' => 'Browser Message Update', 'route' => 'updateBrowserMessage', 'type' => 3, 'parent_route' => 'EmailTemp'],
            ['name' => 'Sms Message Update', 'route' => 'updateSmsMessage', 'type' => 3, 'parent_route' => 'EmailTemp'],

            ['name' => 'School Subject', 'route' => 'schoolSubject', 'type' => 2, 'parent_route' => 'courses'],
            ['name' => 'Add', 'route' => 'schoolSubject.store', 'type' => 3, 'parent_route' => 'schoolSubject'],
            ['name' => 'Edit', 'route' => 'schoolSubject.edit', 'type' => 3, 'parent_route' => 'schoolSubject'],
            ['name' => 'Delete', 'route' => 'schoolSubject.destroy', 'type' => 3, 'parent_route' => 'schoolSubject'],


         ];
        permissionUpdateOrCreate($routes);

    }
    public function down()
    {
        //
    }
}
