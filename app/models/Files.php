<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/2/2015
 * Time: 5:20 PM
 */

class Files extends Eloquent {

    protected $table = 'files';
    protected $guarded = array('id');

    public function filesFolder() {
        return $this->belongsTo('FilesFolder', 'folderID', 'id')->where('delFlag', 0);
    }
    public function filesFolderDeleted() {
        return $this->belongsTo('FilesFolder', 'folderID', 'id')->where('delFlag', 1);
    }

} 