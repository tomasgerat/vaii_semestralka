<?php


namespace App\Models\DataModels;


class EntriesCount extends ADataModel
{
    public $count;
    public static function setDbColumns()
    {
        return ['count'];
    }
}