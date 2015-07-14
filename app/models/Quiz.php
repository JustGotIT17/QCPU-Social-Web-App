<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/29/2015
 * Time: 11:43 PM
 */

class Quiz extends Eloquent {

    protected $table = 'quiz';
    protected $guarded = array('id');


    public function groupPage() {
        return $this->hasManyThrough('GroupPage', 'quizgrouppage', 'quizID', 'grouppageID');
    }
} 