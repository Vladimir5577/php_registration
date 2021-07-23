<?php 

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;

use Josantonius\Session\Session;

class ProductController extends Controller
{

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function showAction(int $id)
	{



        $user = new User();
        $users = $user->get();

        // $user->name = 'Donna';
        // $user->country = 'US';
        // $user->save();

        // foreach ($data as $value) {
        //     dump($value->name);
        // }

        // dd('Finish');

        $product = new Product();
        $product->read($id);

        // dd($product);

        echo $this->twig->render('product.html.twig', [
            'users' => $users,
            'captcha' => $this->captcha,
        ]);
	}

}