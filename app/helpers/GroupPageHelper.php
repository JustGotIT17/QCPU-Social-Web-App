<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 2/6/2015
 * Time: 9:09 PM
 */

class GroupPageHelper {

    public static function activityStatus($done) {
        return $done ? '<span class="badge alert-danger">Closed</span>' : '<span class="badge alert-info">Ongoing</span>';
    }
} 