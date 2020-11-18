<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Categories;
use App\Models\Topics;
class HomeController extends AControllerBase
{

    public function index()
    {
        $user = "jano"; //TODO  z prihlasenia
        return [ "topics" => Topics::getAllForUser($user), "categories" => Categories::getAllCategories()];
    }

}