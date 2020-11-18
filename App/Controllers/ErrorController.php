<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Topic;

class ErrorController extends AControllerBase
{

    public function index()
    {
        return null;
    }
    public function addTopic()
    {
        return ['text' => 'Failed to add topic!'];
    }
    public function deleteTopic()
    {
        return ['text' => 'Failed to delete topic!'];
    }
    public function editTopic()
    {
        return ['text' => 'Failed to edit topic!'];
    }
    public function getTopic()
    {
        return ['text' => 'Failed to get topic!'];
    }
    public function getComment()
    {
        return ['text' => 'Failed to get comment!'];
    }
}