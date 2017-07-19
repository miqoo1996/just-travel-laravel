<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCalculator extends Model
{
    /**
     * @var string
     */
    public static $selectedRoom = 'single';

    /**
     * @var array
     */
    protected static $rooms = [
        '1' => '18',
        '2' => '28',
        '3' => '38'
    ];

    /**
     * @var array
     */
    protected static $allowedRooms = [
        ['1', '0', '0', 'single'],
        ['1', '0', '1', 'single'],
        ['1', '1', '1', 'double'],
        ['1', '1', '0', 'double'],
        ['2', '0', '0', 'double'],
        ['2', '0', '1', 'double'],
        ['2', '1', '0', 'triple'],
        ['2', '1', '1', 'triple'],
        ['3', '0', '0', 'triple'],
    ];

    /**
     * @var array
     */
    protected static $humans = [
        'adult' => '10',
        'child' => '5',
        'infant' => '3'
    ];

    /**
     * @var array
     */
    protected static $adultPriceLabels = [
      1 => 'single_adult',
      2 => 'double_adult',
      3 => 'triple_adult',
    ];

    /**
     * @param $adult
     * @param $child
     * @param $infant
     * @return bool
     */
    public static function isAllowed($adult, $child, $infant)
    {
        if ($adult == 3 && ($child > 0 || $infant > 0)) {
            return false;
        }
        if ($child > 1 || $infant > 1) {
            return false;
        }
        foreach (self::$allowedRooms as $room) {
            list($adult_room, $child_room, $infant_room, $room_selected) = $room;
            if ($adult_room == $adult && $child_room == $child && $infant_room == $infant) {
                self::$selectedRoom = $room_selected;
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $adult
     * @param int $child
     * @param int $infant
     * @return null
     */
    public static function calc($adult = 0, $child = 0, $infant = 0)
    {
        if (!self::isAllowed($adult, $child, $infant)) {
            return null;
        }
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

    /**
     * @param $search
     * @param $array
     * @return null
     */
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

    /**
     * @param $hotel
     * @param int $adult
     * @param int $child
     * @param int $infant
     * @return mixed
     */
    public static function calcHotelPrice($hotel, $adult = 1, $child = 0, $infant = 0)
    {
        return $hotel[self::$selectedRoom . '_adult'];
        $adultPriceLabel = self::$adultPriceLabels[$adult];
        $price = $hotel[$adultPriceLabel] + $child * $hotel['child'] + $infant * $hotel['infant'];
        return $price;
    }
}
