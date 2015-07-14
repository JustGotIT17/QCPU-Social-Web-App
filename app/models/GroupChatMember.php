<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/8/2014
 * Time: 6:31 PM
 */

class GroupChatMember extends Eloquent{
    protected $table = 'groupchatmember';
    protected $guarded = array('ID');

    public function members() {
        return $this->belongsTo('user');
    }
    public function user() {
        return $this->belongsTo('user', 'StudentID', 'StudentID');
    }
    public function activeUsers() {
        return $this->belongsTo('User', 'StudentID', 'StudentID');
    }
    public function groupChat() {
        return $this->belongsTo('GroupChat', 'GCID', 'ID');
    }

    public static function alreadyMember($GCID, $StudentID) {
        $check = GroupChatMember::where('GCID', $GCID)->where('StudentID', $StudentID)->where('delFlag', 0)->first();
        if(count($check))
            return true;
        else
            return false;
    }
} 