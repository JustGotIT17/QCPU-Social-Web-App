<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/20/2014
 * Time: 11:13 AM
 */

class Notification extends Eloquent {

    protected $table = 'notification';
    protected $guarded = array('id');

    public function post() {
        return $this->belongsTo('Post', 'post_id', 'id');
    }

    public function owner() {
        return $this->belongsTo('User', 'StudentID', 'StudentID');
    }
    public function notificationEvent() {
        return $this->belongsTo('NotificationEventType', 'notificationEventTypeID', 'id');
    }

    public function groupPage() {
        return $this->belongsTo('GroupPage', 'grouppageID', 'grouppageID');
    }

    public function groupPageActivity() {
        return $this->belongsTo('GroupPageActivity', 'grouppageactivityID', 'id');
    }
    public function quiz() {
        return $this->belongsTo('Quiz', 'quizID', 'id');
    }
    public function groupPagePost() {
        return $this->belongsTo('GroupPagePost', 'grouppagepostID', 'grouppagepostID');
    }

}