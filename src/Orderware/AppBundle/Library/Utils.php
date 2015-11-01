<?php

namespace Orderware\AppBundle\Library;

use \DateTime;

class Utils
{

    /**
     * Returns a value of an array by key.
     *
     * @param array $array
     * @param mixed $key
     */
    public static function arrayValue(array $array, $key)
    {
        if (!is_scalar($key) || !array_key_exists($key, $array)) {
            return null;
        }

        return $array[$key];
    }

    /**
     * Returns a database representation of a boolean value.
     *
     * @param boolean $value
     * @return string
     */
    public static function dbBool($value)
    {
        return (!(bool)$value ? 'f' : 't');
    }

    /**
     * Creates an ISO timestamp in YYYY-MM-DD HH:MM:SS format.
     *
     * @param mixed $date
     * @return string
     */
    public static function dbDate($date = null)
    {
        $time = false;
        $formatStr = 'Y-m-d H:i:s';

        if ($date instanceof DateTime) {
            return $date->format($formatStr);
        } elseif (!empty($date)) {
            $time = strtotime($date);
        }

        if (!$time) {
            $time = time();
        }

        return date($formatStr, $time);
    }

    /**
     * Generates a non-secure random string.
     *
     * @param integer $length
     * @return string
     */
    public static function randomString($length = 8)
    {
        $length = abs((int)$length);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $poolLength = strlen($pool) - 1;

        $random = '';

        for ($i=0; $i<$length; $i++) {
            $random .= $pool[mt_rand(0, $poolLength)];
        }
        
        return $random;
    }

}
