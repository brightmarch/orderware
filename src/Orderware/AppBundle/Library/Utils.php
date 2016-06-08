<?php

namespace Orderware\AppBundle\Library;

class Utils
{

    /**
     * Casts a value to a database boolean.
     *
     * @param string $value
     * @return string
     */
    public static function dbBool(string $value)
    {
        return ('true' === strtolower($value) ? true : false);
    }

}
