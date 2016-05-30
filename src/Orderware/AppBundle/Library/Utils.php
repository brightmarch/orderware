<?php

namespace Orderware\AppBundle\Library;

class Utils
{

    /**
     * Casts a value to a database boolean.
     *
     * @param mixed $value
     * @return string
     */
    public static function dbBool($value)
    {
        if (is_bool($value)) {
            return (true === $value ? 't' : 'f');
        }

        return ('true' === strtolower($value) ? 't' : 'f');
    }

    /**
     * Returns an ISO YYYY-MM-DD HH:mm:ss date format.
     *
     * @param mixed $time
     * @return string
     */
    public static function dbDate($time = null)
    {
        if (!is_int($time)) {
            $time = time();
        }

        return date('Y-m-d H:i:s', $time);
    }

}
