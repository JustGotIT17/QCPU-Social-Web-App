<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/29/2015
 * Time: 11:43 PM
 */

class QuizItem extends Eloquent{
    protected $table = 'quizitem';
    protected $guarded = array('id');

    public function quizItemChoices() {
        return $this->hasMany('QuizItemChoice', 'quizItemID');
    }

    public function quizItemAnswer() {
        return $this->hasMany('QuizItemAnswer', 'quizItemID');
    }

} 