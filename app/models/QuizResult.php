<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/29/2015
 * Time: 11:46 PM
 */

class QuizResult extends Eloquent {
    protected $table = 'quizresult';
    protected $guarded = array('id');

    public function owner() {
        return $this->belongsTo('User', 'OwnerID', 'StudentID');
    }

} 