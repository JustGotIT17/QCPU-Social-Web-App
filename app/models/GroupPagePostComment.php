<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/20/2015
 * Time: 8:35 PM
 */

class GroupPagePostComment extends Eloquent{

    protected $table = 'groupcommentbox';
    protected $guarded = array('groupcommentboxID');

    public function groupPagePost() {
        return $this->belongsTo('GroupPagePost', 'grouppagepostID', 'grouppagepostID');
    }

    public function owner() {
        return $this->belongsTo('User', 'StudentID', 'StudentID');
    }
} 