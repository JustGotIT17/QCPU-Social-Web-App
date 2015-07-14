<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/14/2015
 * Time: 11:18 AM
 */

class DownloadFileController extends BaseController {

    public function downloadGroupPageFile($id, $StudentID, $reqFile) {
        $file = File::get($reqFile);
        return Response::make($file, 200, array('Content-type' => 'application/docx'));
    }
    public function downloadMyFilesFile($StudentID, $reqFile) {
        $file = File::get($reqFile);
        return Response::make($file, 200, array('Content-type' => 'application/docx'));
    }



} 