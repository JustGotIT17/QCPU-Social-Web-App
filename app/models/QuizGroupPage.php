<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/30/2015
 * Time: 4:21 PM
 */

class QuizGroupPage extends Eloquent {
    protected $table = 'quizgrouppage';
    protected $guarded = array('id');

    public function groupPage() {
        return $this->belongsTo('GroupPage', 'grouppageID', 'grouppageID');
    }

    public function quiz() {
        return $this->belongsTo('Quiz', 'quizID', 'id');
    }

    public function groupPageMember() {
        return $this->belongsTo('GroupPageMember', 'grouppageID', 'grouppageID')->where('StudentID', Auth::user()->StudentID)->where('delFlag', 0);
    }

    public function owner() {
        return $this->belongsTo('User', 'OwnerID', 'StudentID');
    }
}