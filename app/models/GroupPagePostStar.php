<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/20/2015
 * Time: 9:36 PM
 */

class GroupPagePostStar extends Eloquent {

    protected $table = 'groupstar';
    protected $guarded = array('groupstarID');


    public function groupPagePost() {
        return $this->belongsTo('GroupPagePost', 'grouppagepostID', 'grouppagepostID');
    }

    public static function updateStar($id, $AccID, $newValue){
        return GroupPagePostStar::where('grouppagepostID', $id)->where('StudentID', $AccID)->update(array('groupstarstar'=>$newValue)) ? true : false;
    }

    public static function addStar($id, $AccID) {
        GroupPagePostStar::create([
            'grouppagepostID' => $id,
            'StudentID' => $AccID,
            'groupstarstar' => 1
        ]);
    }
} 