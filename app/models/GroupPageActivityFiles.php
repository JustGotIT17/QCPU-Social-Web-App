<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/9/2015
 * Time: 11:24 AM
 */

class GroupPageActivityFiles extends Eloquent {

    protected $table = 'grouppageactivityfiles';
    protected $guarded = array('id');

    public function groupPageActivity() {
        return $this->belongsTo('GroupPageActivity', 'grouppageactivityID', 'id');
    }
    public function groupPageActivityGroup() {
        //grouppageactivityID = grouppageactivityGroupID
        return $this->belongsTo('GroupPageActivityGroup', 'grouppageactivityID', 'id');
    }

    public function owner() {
        return $this->belongsTo('User', 'OwnerID', 'StudentID');
    }

    public static function hasSubmitted($groupPageActID) {
        return GroupPageActivityFiles::where('OwnerID', Auth::user()->StudentID)->where('grouppageactivityID', $groupPageActID)->first();
    }
} 