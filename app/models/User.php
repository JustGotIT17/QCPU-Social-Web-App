<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';
    protected $guarded = array('id');
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    public function type() {
        return $this->belongsTo('UserType', 'user_type_id', 'id');
    }

    public function posts() {
        return $this->hasMany('Post', 'StudentID');
    }
    public function messages() {
        return $this->hasMany('Message', 'StudentID', 'RecipientID');
    }
    public function gender() {
        return $this->belongsTo('Gender', 'GenderID', 'GenderID');
    }
    public function course() {
        return $this->belongsTo('Course', 'CourseID', 'CourseID');
    }
    public function groupChat() {
        return $this->belongsTo('GroupChat');
    }
    public function groupChatMember() {
        return $this->belongsTo('GroupChatMember', 'StudentID', 'StudentID')->where('delFlag', 0);
    }
    public function groupChatMessage() {
        return $this->hasMany('GroupChatMessage');
    }
    public function filesFolder() {
        return $this->hasMany('FilesFolder');
    }
    public function userType() {
        return $this->belongsTo('UserType', 'UserTypeID', 'id');
    }
    public function groupPageOwner() {
        return $this->belongsTo('GroupPage', 'StudentID', 'StudentID');
    }
    public function groupPageAssistant() {
        return $this->belongsTo('GroupPage', 'assistantID', 'StudentID');
    }
    public function groupPageMember() {
        return $this->belongsTo('GroupPageMember', 'StudentID', 'StudentID')->where('delFlag', 0);
    }
    public static function getStatus($id) {
        $user = User::find($id);
        return $user->online;
    }
    public static function getProfileImage($src) {
        return "http://localhost/qcpusociallearning/img/profile/".$src;
    }
    public static function updateLastSeen() {
        User::where('StudentID', Auth::user()->StudentID)->update(array('lastSeen'=>MyDate::getNormalDateFormat()));
    }
    public static function getAllOnlineUsers() {
        return User::where('StudentID', '!=', Auth::user()->StudentID)->where('lastSeen', '>=', date_sub(date_create(MyDate::getNormalDateFormat()), date_interval_create_from_date_string("1 minute")))->get();
    }
    public static function addLoginRecord() {
        LoginRecord::create([
            'OwnerID' => Auth::user()->StudentID,
            'deviceID' => 2
        ]);
    }
    public static function getUser($id) {
        $user = User::where('StudentID', $id)->first();
        return $user;
    }
    public static function isOnline($lastSeen) {
        $date1 = date_sub(date_create(MyDate::getNormalDateFormat()), date_interval_create_from_date_string("1 minute"));
        $check = strtotime(MyDate::getNormalDateFormat()) - strtotime($lastSeen) > 1000 ? false : true;
        $check ? User::displayOnlineStatus() : '';
    }

    private static function displayOnlineStatus() {
        return '<i class="fa fa-check-circle fa-fw text-success"></i> <small class="text-success">online</small>';
    }
}
