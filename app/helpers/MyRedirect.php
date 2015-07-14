<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 2/6/2015
 * Time: 11:53 AM
 */

class MyRedirect {

    public static function toUrl ($url ,$message, $view) {
        return Redirect::to($url)->with('message',$message)->with('url',$view);
    }
} 