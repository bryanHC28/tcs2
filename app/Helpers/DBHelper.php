<?php

namespace App\Helpers;

class DBHelper
{

    /**
     * DB to array
     *
     * @param array $dbObject
     * @return Array $db_array
     */
    public static function dbToArray(array $dbObject)
    {
        return array_map(
            function ($value) {
                return (array)$value;
            },
            $dbObject
        );
    }

    /**
     * DB to ArrayCollection
     *
     * @param array $dbObject
     * @return ArrayCollection $db_array
     */
    public static function dbToArrayCollection(array $dbObject)
    {
        return collect((new Self)->dbToArray($dbObject));
    }
}
