<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function saveUserToDatabase();

    public function validateRegisterForm();

    public function saveValidUserData();

}