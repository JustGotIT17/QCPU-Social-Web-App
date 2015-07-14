<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 2/1/2015
 * Time: 5:06 PM
 */

class MyDate {

    public static function getDateFormat() {
        return 'M-d-Y | h:i A';
    }
    public static function getNormalDateFormat() {
        return date('Y-m-d h:i:s');
    }
    public static function onGoing($date1, $date2) {
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        return ($date1 > $date2) ? false : true;
    }

    public static function present($date1, $date2) {
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        return ($date1 == $date2) ? true : false;
    }
} 