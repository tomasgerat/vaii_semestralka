<?php


namespace App\Models\DataModels;


class EntriesCount
{
    public $count;
    public static function getDbColumns()
    {
        return ['count'];
    }
}