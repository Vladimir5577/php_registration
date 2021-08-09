<?php

namespace App\Interfaces;

interface UserInterface
{

	public function validateUserForm();

	public function saveValidUserData();

	public function getSortedUsers($sort);
}