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
        try {
            $topics = Topics::getAllForUser($user);
        } catch (\Exception $e) {
            header("Location: vaii_semestralka?c=Error&a=getTopic");
            die();
        }
        return ["topics" => $topics, "categories" => Categories::getAllCategories()];
    }

}