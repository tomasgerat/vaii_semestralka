<?php


namespace App\Models\DataModels;


class TopicInCategoriesCnt extends ADataModel
{
    public $computers;
    public $games;
    public $science;
    public $movies;
    public $music;
    public $other;
    static public function setDbColumns()
    {
        return ['computers', 'games', 'science', 'movies', 'music', 'other'];
    }

}