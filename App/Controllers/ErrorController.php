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
    public function addComment()
    {
        return ['text' => 'Failed to add comment!'];
    }
    public function editComment()
    {
        return ['text' => 'Failed to edit comment!'];
    }
    public function deleteComment()
    {
        return ['text' => 'Failed to delete comment!'];
    }


}