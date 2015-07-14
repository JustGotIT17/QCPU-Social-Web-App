<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/26/2014
 * Time: 11:04 AM
 */

class GroupPage extends Eloquent{

    protected $table = 'grouppage';
    protected $guarded = array('grouppageID');

    public function groupPageMembers() {
        return $this->hasMany('GroupPageMember');
    }


    public static function isMember($id, $StudentID) {
        $check = GroupPageMember::where('grouppageID', $id)->where('StudentID', $StudentID)->where('delFlag', 0)->first();
        return ($check) ?  true :  false;
    }

    public static function isAdmin($id, $StudentID) {
        $check = GroupPage::where('grouppageID', $id)->where('StudentID', $StudentID)->where('delFlag', 0)->first();
        return ($check) ? true : false;
    }
    public static function isAssistant($id, $StudentID) {
        $check = GroupPage::where('grouppageID', $id)->where('assistantID', $StudentID)->first();
        return ($check) ? true : false;
    }

    public static function hasRights($id, $StudentID) {
        return (GroupPage::isAdmin($id, $StudentID)) ? true : GroupPage::isAssistant($id, $StudentID);
    }

    public static function getGroupPage($id) {
        return GroupPage::where('grouppageID', $id)->first();
    }

    public static function isBelong($id, $StudentID) {
        return GroupPage::isMember($id, $StudentID) ? true : GroupPage::isAdmin($id, $StudentID);
    }
}