<?php

namespace Orderware\AppBundle\Library;

class Utils
{

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
