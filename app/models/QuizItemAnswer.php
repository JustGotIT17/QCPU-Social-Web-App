<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/29/2015
 * Time: 11:45 PM
 */

class QuizItemAnswer extends Eloquent{
    protected $table = 'quizitemanswer';
    protected $guarded = array('id');


    public static function checkAnswer($quizItemID, $ans) {
        $correctAnswer = QuizItemAnswer::where('quizItemID',$quizItemID)->first();
        if(count($correctAnswer)) {
            return ($correctAnswer->answer === $ans) ? true : false;
        }
    }
} 