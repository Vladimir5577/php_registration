<?php 

namespace App\Controllers;

/**
 * Class PageController
 * @package App\Controllers
 */
class PageController
{
    // Homepage action
	public function indexAction()
	{
		
		
        require_once APP_ROOT . '/views/home.php';
	}
}