<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/3/2015
 * Time: 10:04 PM
 */

class GroupPageFiles extends Eloquent {

    protected $table = 'grouppagefiles';
    protected $guarded = array('id');

    public function groupPagePost() {
        return $this->belongsTo('GroupPagePost', 'grouppagepostID', 'grouppagepostID');
    }

}