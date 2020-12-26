<?php


namespace App\Models\DataModels;


abstract class ADataModel implements \JsonSerializable
{
    abstract static public function setDbColumns();

    /**
     * Default implementation of JSON serialize method
     * @return array|mixed
     */

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}