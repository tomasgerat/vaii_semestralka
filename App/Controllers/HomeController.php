<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Categories;
use App\Models\Topics;
class HomeController extends AControllerBase
{

    public function index()
    {
        return [ "topics" => Topics::getAllForUser("jano"), "categories" => Categories::getAllCategories()];
    }

}