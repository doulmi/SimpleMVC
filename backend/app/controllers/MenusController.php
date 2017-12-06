<?php
namespace App\Controllers;

use Core\Base\Controller;

class MenusController extends Controller
{
    public function index()
    {
        $menus = [];
        for ($i = 0; $i < 20; $i++) {
            $menus[] = [
                'id' => $i,
                'image' => 'http://via.placeholder.com/128x128',
                'name' => 'Menu' . $i,
                'description' => $i . 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                'price' => rand(1, 50)
            ];
        }

        echo json_encode($menus);
    }
}