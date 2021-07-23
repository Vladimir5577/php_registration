<?php

require_once 'vendor/autoload.php';
require_once 'config/config.php';

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('key');
    $table->string('name')->nullable();
    $table->string('photo')->nullable();
    $table->boolean('is_active')->default(false);
    $table->date('registered_at');
});

dump('Table user created cuccessfully!');