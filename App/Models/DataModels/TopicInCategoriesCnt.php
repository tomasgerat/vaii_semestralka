<?php


namespace App\Models\DataModels;


class TopicInCategoriesCnt
{
    public $computers;
    public $games;
    public $science;
    public $movies;
    public $music;
    public $other;
    static public function getDbColumns()
    {
        return ['computers', 'games', 'science', 'movies', 'music', 'other'];
    }

}