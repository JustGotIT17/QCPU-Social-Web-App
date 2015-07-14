<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/22/2015
 * Time: 11:15 PM
 */

class GroupPageActivityGroup extends Eloquent {

    protected $table = 'grouppageactivitygroup';
    protected $guarded = array('id');

    public function groupPageActivity() {
        return $this->belongsTo('GroupPageActivity', 'grouppageactivityID', 'id');
    }
    public function groupPage() {
        return $this->belongsTo('GroupPage', 'grouppageID', 'grouppageID');
    }
    public function groupPageActivityFiles() {
        return $this->hasMany('GroupPageActivityFiles', 'grouppageactivityID', 'grouppageactivityID')->where('ownerID', Auth::user()->StudentID);
    }

} 