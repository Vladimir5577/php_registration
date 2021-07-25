<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function saveUserToDatabase();

    public function validateRegisterForm();

    public function saveValidUserData();


    public function loginUser();
    
    public function validateLoginForm();
    
    public function tryLoginWithValidUserCredentials($email, $password);
    

}