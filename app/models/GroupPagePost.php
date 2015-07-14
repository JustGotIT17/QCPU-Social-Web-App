<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/26/2014
 * Time: 11:05 AM
 */

class GroupPagePost extends Eloquent{

    protected $table = 'grouppagepost';
    protected $guarded = array('grouppagepostID');

    public function owner() {
        return $this->belongsTo('User', 'StudentID', 'StudentID');
    }

    public function groupPageFiles() {
        return $this->hasMany('GroupPageFiles', 'grouppagepostID', 'grouppagepostID');
    }

    public function comments() {
        return $this->hasMany('GroupPagePostComment', 'grouppagepostID', 'grouppagepostID')->where('delFLag', 0);
    }
    public function stars() {
        return $this->hasMany('GroupPagePostStar', 'grouppagepostID', 'grouppagepostID')->where('groupstarstar', 1);
    }
    public function myStars() {
        return $this->hasMany('GroupPagePostStar', 'grouppagepostID', 'grouppagepostID')->where('groupstarstar', 1)->where('StudentID', Auth::user()->StudentID);
    }
    public static function getGroupPagePostByID($id) {
        return GroupPagePost::where('grouppagepostID', $id)->first();
    }



} 