<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/9/2015
 * Time: 11:26 AM
 */

class GroupPageActivity extends Eloquent {

    protected $table = 'grouppageactivity';
    protected $guarded = array('id');

    public function groupPageActivityFiles() {
        return $this->hasMany('GroupPageActivityFiles', 'grouppageactivityID', 'id');
    }
    public function groupPageActivityGroup() {
        return $this->hasMany('GroupPageActivityGroup', 'id', 'grouppageactivityID');
    }
} 