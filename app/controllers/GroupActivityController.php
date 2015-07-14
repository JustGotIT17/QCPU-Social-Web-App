<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/22/2015
 * Time: 9:23 PM
 */

class GroupActivityController extends BaseController {

    public function addActivity() {
        return View::make('validated.activity.addActivity');
    }

    public function createActivity() {
        $in = Input::all();
        $rules = [
            'name'=>'required',
            'desc'=>'required'
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            GroupPageActivity::create([
                'name'=>$in['name'],
                'description'=>$in['desc'],
                'OwnerID'=>Auth::user()->StudentID
            ]);
            return Redirect::to('/')->with('message', 'Activity successfully created')->with('url', '');
        }
        return Redirect::to('/')->with('message', 'Error activity creation')->with('url', '');
    }

    public function viewActivity($id) {
        $activity = GroupPageActivity::find($id);
        $activityGroups = GroupPageActivityGroup::with('groupPage')->where('grouppageactivityID', $id)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.activity.view', compact('activity', 'activityGroups'));
    }

    public function viewDesignation($acid) {
        $activity = GroupPageActivity::find($acid);
        $time = Time::generateTime('time');
        $groups = DB::table('grouppage')->where('StudentID', Auth::user()->StudentID)->whereNotExists(function($query) use($acid){
            $query->select(DB::raw(1))->from('grouppageactivitygroup')->whereRaw('grouppageactivitygroup.grouppageID = grouppage.grouppageID')
                ->whereRaw('grouppageactivitygroup.grouppageactivityID = '. $acid);
        })->orderBy('Name', 'ASC')->lists('Name', 'grouppageID');

        return View::make('validated.activity.viewDesignation', compact('activity', 'groups', 'time'));
    }

    public function viewSubmission($groupPageActivityGroupID, $actID) {
        $activity = GroupPageActivity::find($actID);
        $groupActivityFiles = GroupPageActivityFiles::with('owner', 'groupPageActivityGroup')->where('grouppageactivityID',$groupPageActivityGroupID)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.activity.viewSubmission', compact('activity', 'groupActivityFiles'));
    }

    public function viewSettings($id) {
        $activity = GroupPageActivity::find($id);
        return View::make('validated.activity.viewSettings', compact('activity'));
    }

    public function createDesignation() {
        $in = Input::all();
        $rules = [
            'group' => 'required',
            'deadline'=> 'required',
            'time'=> 'required',
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            $activity = GroupPageActivity::find( $in['grouppageactivityID']);
            $gpaGroup = GroupPageActivityGroup::create([
                'grouppageactivityID' => $in['grouppageactivityID'],
                'grouppageID' => $in['group'],
                'deadline' => $in['deadline']. ' ' .$in['time']
            ]);
            if($gpaGroup) {
                $gpPost = GroupPagePost::create([
                    'grouppageID' => $in['group'],
                    'StudentID' => Auth::user()->StudentID,
                    'Message' => '<h5>Activity name:</h5>'. $activity->name . '<br/><h5>Description:</h5>' . $activity->description . '<br/><span class="timeago">Deadline: '.date(MyDate::getDateFormat(), strtotime($in['deadline'])).'</span><p>Kindly check your activities Tab</p>'
                ]);
                Notification::create([
                    'StudentID' => Auth::user()->StudentID,
                    'grouppageID'=>$in['group'],
                    'grouppageactivityID'=>$in['grouppageactivityID'],
                    'grouppagepostID'=>$gpPost->id,
                    'notificationEventTypeID'=>1,
                    'seen'=>0,
                ]);
            }
            return Redirect::to('/')->with('message', 'Group activity designation successful')->with('url', '/group/activities/view/'.$in['grouppageactivityID']);
        }
        return Redirect::to('/')->with('message', 'Error in group activity designation')->with('url', '/group/activities/view/'.$in['grouppageactivityID']);
    }

    public function submitFile($id) {
        $files = Input::file('files');

        foreach($files as $file) {
            $rules = array(
                'file' => FileTypes::getAllFileTypes()
            );

            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->passes()) {
                $randomId = Str::random(14);

                $destinationPath = 'uploads/group/activity/'. Auth::user()->StudentID.'/';
                $filename =$file->getClientOriginalName();
                $mime_type = $file->getMimeType();
                $extension = $file->getClientOriginalExtension();
                $upload_success = $file->move('public/'.$destinationPath,  $randomId.$filename);
                if($upload_success) {
                    $check = GroupPageActivityFiles::hasSubmitted($id);
                    if(!count($check)) {
                        GroupPageActivityFiles::create([
                            'path' => $destinationPath. $randomId.$filename,
                            'filename' => $filename,
                            'grouppageactivityID' => $id,
                            'OwnerID' => Auth::user()->StudentID,
                        ]);
                    } else {
                        $check->update(array('path'=>$destinationPath. $randomId.$filename, 'filename'=>$filename));
                    }
                    return Redirect::to('/')->with('message', 'Successfully submitted your activity')->with('url','');
                }
            }
        }
        return Redirect::to('/')->with('message', 'Error submitted your activity')->with('url','');
    }
} 