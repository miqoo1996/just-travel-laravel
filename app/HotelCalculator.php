<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCalculator extends Model
{
    protected static $rooms = [
        '1' => '18',
        '2' => '28',
        '3' => '38'
    ];

    protected static $humans = [
        'adult' => '10',
        'child' => '5',
        'infant' => '3'
    ];



    public static function calc($adult = 0, $child = 0, $infant = 0)
    {
        $result = 0;
        $infantCounter = 0;
        $result += $adult * self::$humans['adult'];
        $result += $child * self::$humans['child'];
        if ($infant !== 0) {
            while ($infantCounter < $infant) {
                $result += self::$humans['infant'] + $infantCounter;
                $infantCounter++;
            }
        }
        $closest = self::getClosest($result, self::$rooms);
        return $closest;
    }

    public static function getClosest($search, $array)
    {
        sort($array);
        foreach ($array as $a) {
            if ($a >= $search){
                $closest = $a;
                break;
            }
        }
        if (isset($closest)) {
            $closest = ($search <= $closest) ? array_flip(self::$rooms)[$closest] : null;
            return $closest;
        }
        return null;
    }
}
