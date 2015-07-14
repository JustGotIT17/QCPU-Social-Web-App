<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/17/2015
 * Time: 5:21 PM
 */

class GroupPageJoin extends Eloquent {

    protected $table = 'grouppagejoin';
    protected $guarded = array('id');

    public function user() {
        return $this->belongsTo('User', 'StudentID', 'StudentID');
    }

    public static function isRequested($id) {
        $check = GroupPageJoin::where('grouppageID' ,$id)->where('StudentID', Auth::user()->StudentID)->where('delFlag', 0)->first();
        return ($check) ? true : false;
    }


} 