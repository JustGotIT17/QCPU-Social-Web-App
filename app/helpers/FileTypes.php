<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/28/2015
 * Time: 9:24 PM
 */

class FileTypes {

    public static function getAllFileTypes() {
        return 'required|mimes:doc,docx,pdf,ppt,pptx,rar,zip,jpeg,jpg,png';
    }
} 