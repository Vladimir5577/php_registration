<?php

namespace App\Interfaces;

interface AuthInterface
{
    /**
     * @return mixed
     */
    public function saveUserToDatabase();

    /**
     * @return mixed
     */
    public function validateRegisterForm();

    /**
     * @return mixed
     */
    public function saveValidUserData();


    /**
     * @return mixed
     */
    public function loginUser();

    /**
     * @return mixed
     */
    public function validateLoginForm();

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function tryLoginWithValidUserCredentials($email, $password);

    /**
     * @param $password
     * @return mixed
     */
    public function hashUserPassword($password);
}