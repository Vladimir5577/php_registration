<?php

require_once 'vendor/autoload.php';
require_once 'config/config.php';

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class UserMigration
 */
class UserMigration
{
    public function run()
    {
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('key')->unique();
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(false);
            $table->date('registered_at');
        });
    }
}

$UserMigration = new UserMigration;
$UserMigration->run();

dump('Table user created cuccessfully!');