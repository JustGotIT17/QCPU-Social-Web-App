<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/26/2014
 * Time: 1:59 PM
 */

class GroupPageController extends BaseController{

    public function view($id) {
        $groupPages = GroupPage::where('grouppageID', $id)->first();
        $groupPosts = GroupPagePost::with('owner', 'groupPageFiles', 'comments', 'myStars')->where('grouppageID', $id)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        $members = GroupPageMember::with('owner')->where('grouppageID', $id)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        $files = GroupPageFiles::where('grouppageID', $id)->orderBy('created_at', 'DESC')->get();
        $joins = GroupPageJoin::with('user')->where('grouppageID', $id)->where('delFlag', 0)->get();
        $admin = User::getUser($groupPages->StudentID);
        $assistant = User::getUser($groupPages->assistantID);
        return View::make('validated.grouppage.view', compact('groupPages', 'groupPosts', 'members', 'files', 'joins', 'admin', 'assistant'));
    }

    public function postToWall($id) {
        $groupPage = GroupPage::getGroupPage($id);
        return View::make('validated.grouppage.post', compact('groupPage'));
    }

    public function postMessage($id) {
        $files = Input::file('files');
        $in = Input::all();
        $grouppagepostID = GroupPagePost::create([
           'grouppageID' => $id,
            'StudentID' => Auth::user()->StudentID,
            'Message' => $in['message']
        ]);


        foreach($files as $file) {
            $rules = array(
                'file' => 'required|mimes:doc,docx,pdf,ppt,pptx,rar,zip,jpeg,jpg,png'
            );

            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->passes()) {
                $randomID = Str::random(14);

                $destinationPath = 'uploads/grouppage/files/' .$id. '/' . Auth::user()->StudentID.'/';
                $filename = $file->getClientOriginalName();
                $mime_type = $file->getMimeType();
                $extension = $file->getClientOriginalExtension();
                $upload_success = $file->move('public/'.$destinationPath, $randomID. $filename);
                if($upload_success) {
                    GroupPageFiles::create([
                        'path' => $destinationPath . $randomID.$filename,
                        'filename' => $filename,
                        'grouppagepostID'=> $grouppagepostID->id,
                        'grouppageID' => $id,
                        'OwnerID' => Auth::user()->StudentID
                    ]);
                }
            }
        }
        return Redirect::to('/')->with('message', 'Successfully Posted.')->with('url','/grouppage/view/'.$id);
    }

    public function postDeleteMessage($id) {
        $in = Input::all();
        $check = GroupPage::isAdmin($in['id'], Auth::user()->StudentID) ? true : count(GroupPagePost::getGroupPagePostByID($id)) > 0 ? true : false;

        $check ? GroupPagePost::where('grouppagepostID', $id)->update(array('delFlag'=> 1)) : '';

    }

    public function addGroupPage() {
        return View::make('validated.grouppage.addGroupPage');
    }

    public function askJoin($id) {
        $check = GroupPageJoin::where('grouppageID' ,$id)->where('StudentID', Auth::user()->StudentID)->where('delFlag', 0)->first();
        if(!$check) {
            GroupPageJoin::create([
               'grouppageID' => $id,
                'StudentID' => Auth::user()->StudentID
            ]);
        }
    }

    public function acceptJoin($id) {
        $request = GroupPageJoin::find($id);
        $check = GroupPage::hasRights($request->grouppageID, Auth::user()->StudentID);
        if($check && !GroupPage::isMember($request->grouppageID, $request->StudentID)) {
            $request->delFlag = 1;
            $request->save();
            $add = GroupPageMember::create([
               'grouppageID' => $request->grouppageID,
                'StudentID' => $request->StudentID
            ]);
            if($add) {
                PostNotification::create([
                   'StudentID' => Auth::user()->StudentID,
                    'OwnerID' => $request->StudentID,
                    'agroup' => 1,
                    'grouppageID' => $request->grouppageID,
                    'eventID' => 3
                ]);
            }
        }

    }
    public function searchAssistant() {
        $in = Input::all();
        $user = User::where('StudentID', '<>', Auth::user()->StudentID)->where('StudentID', 'LIKE', '%'.$in['name'].'%')->orWhere('Firstname', 'LIKE', '%'.$in['name'].'%')->orWhere('Lastname', 'LIKE', '%'.$in['name'].'%')->first();
        return View::make('validated.grouppage.search', compact('user'));
    }

    public function postAddGroupPage() {
        $in = Input::all();

        $gp = GroupPage::create([
           'Name' => $in['name'],
            'StudentID' => Auth::user()->StudentID,
            'subject' => $in['subject'],
            'assistantID' => $in['assistant'],
            'description' => $in['description']
        ]);
        GroupPageMember::create([
           'grouppageID' => $gp->id,
            'StudentID' =>  $in['assistant']
        ]);
    }

    public function changeAssistant() {
        $in = Input::all();
        $check = GroupPage::isMember($in['id'], $in['AccID']);
        if($check && !GroupPage::hasRights($in['id'], $in['AccID'])) {
            GroupPage::where('grouppageID', $in['id'])->update(array('assistantID'=>$in['AccID']));
        }
    }

    public function viewActivity($gid, $id) {

        $activity = GroupPageActivityGroup::with('groupPageActivity', 'groupPage')->where('grouppageactivityID', $id)->where('grouppageID', $gid)->first();
        $submittedFile = GroupPageActivityFiles::with('owner')->where('OwnerID', Auth::user()->StudentID)->where('grouppageactivityID', $id)->first();
        if(MyDate::onGoing($activity->deadline, date('Y-m-d H:i:s')))
            return Redirect::To('/')->with('message','The requested page is unavailable.')->with('url','');
        return View::make('validated.grouppage.viewActivity', compact('activity', 'submittedFile'));
    }

    public function viewActivities($id) {
        $groupPage = GroupPage::where('grouppageID', $id)->where('delFlag', 0)->first();
        $activityGroups = GroupPageActivityGroup::with('groupPage', 'groupPageActivity', 'groupPageActivityFiles')->where('grouppageID', $groupPage->grouppageID)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.grouppage.viewActivities', compact('groupPage', 'activityGroups'));
    }

    public function viewSettings($id) {
        $groupPage = GroupPage::getGroupPage($id);
        return View::make('validated.grouppage.viewSettings', compact('groupPage'));
    }

    public function viewAddPeople($id) {
        if(GroupPage::isAdmin($id, Auth::user()->StudentID) || GroupPage::isAssistant($id, Auth::user()->StudentID)) {
            $groupPage = GroupPage::getGroupPage($id);
            return View::make('validated.grouppage.addPeople', compact('groupPage'));
        }
        return Redirect::to('/');
    }
    public function delete() {
        $in = Input::all();
        $check = GroupPage::isAdmin($in['id'], Auth::user()->StudentID);
        if($check) {
            GroupPage::where('grouppageID', $in['id'])->update(array('delFlag'=>1));
        }
    }
    public function searchAddPeople() {
        $in = Input::all();
        $groupPageID = $in['id'];
        $users = User::with('groupPageMember', 'groupPageOwner')->where('StudentID', 'LIKE', '%'.$in['name'].'%')->orWhere('Lastname', 'LIKE', '%'.$in['name'].'%')->orWhere('Firstname', 'LIKE', '%'.$in['name'].'%')->get();
        return View::make('validated.grouppage.viewSearchResult', compact('users', 'groupPageID'));
    }

    public function addPeople() {
        $in = Input::all();
        $check = GroupPage::isMember($in['id'], $in['AccID']) ? true : GroupPage::isAdmin($in['id'], $in['AccID']);
        if(!$check) {
            GroupPageMember::create([
                'grouppageID'=>$in['id'],
                'StudentID'=>$in['AccID']
            ]);
        }
    }

    public function displayPostComment($id, $pid) {
        $groupPage = GroupPage::where('grouppageID', $id)->first();
        $post = GroupPagePost::with('owner', 'groupPageFiles')->where('grouppagepostID', $pid)->first();
        $comments = GroupPagePostComment::with('owner')->where('grouppagepostID', $pid)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.grouppage.viewComments', compact('groupPage','post', 'comments'));
    }

    public function addCommentToPost() {
        $in = Input::all();

        if(GroupPage::isBelong($in['id'], Auth::user()->StudentID) && GroupPagePost::getGroupPagePostByID($in['pid'])->grouppageID == $in['id']) {
            GroupPagePostComment::create([
                'grouppagepostID' => $in['pid'],
                'StudentID' => Auth::user()->StudentID,
                'groupcomment' => $in['message']
            ]);
        }

        return Redirect::to('/')->with('message', 'Comment successsfully posted.')->with('url','/grouppage/'.$in['id'].'/post/'.$in['pid'].'/comment/');
    }
    public function starPost() {
        $in = Input::all();
        $id = $in['id'];
        $AccID = $in['AccID'];
        $check = GroupPagePostStar::where('grouppagepostID', $id)->where('StudentID', $AccID)->orderBy('created_at', 'DESC')->first();
        !count($check) ? GroupPagePostStar::addStar($id, $AccID) : GroupPagePostStar::updateStar($id, $AccID, $check->groupstarstar == 0 ? 1 : 0);
        $data = [
            'count' => GroupPagePostStar::where('grouppagepostID', $id)->where('groupstarstar', 1)->count(),
            'isStar' => $check->groupstarstar == 0 ? 1 : 0
        ];
        return $data;

    }
    public function deletePostComment() {
        $in = Input::all();
        if(Auth::user()->StudentID == $in['AccID'])
            GroupPagePostComment::where('groupcommentboxID', $in['id'])->update(array('delFlag'=> 1));
    }

    public function leave() {
        $in = Input::all();
        $isAdmin = GroupPage::isAdmin($in['id'], $in['AccID']);
        $isMember = GroupPage::isMember($in['id'], $in['AccID']);
        if(!$isAdmin && $isMember) {
            GroupPageMember::where('grouppageID', $in['id'])->where('StudentID', $in['AccID'])->update(array('delFlag'=>1));
            $isAssistant = GroupPage::isAssistant($in['id'], $in['AccID']);
            $isAssistant ? GroupPage::where('grouppageID', $in['id'])->update(array('assistantID'=>GroupPage::getGroupPage($in['id'])->StudentID)) : '';
        }
    }

    public function forceLeave() {
        $in = Input::all();
        $isAdmin = GroupPage::isAdmin($in['id'], $in['AccID']);
        $isAssistant = GroupPage::isAssistant($in['id'], $in['AccID']);
        $isMember = GroupPage::isMember($in['id'], $in['AccID']);
        if(!$isAdmin && $isMember) {
            GroupPageMember::where('grouppageID', $in['id'])->where('StudentID', $in['AccID'])->update(array('delFlag'=>1));
            ($isAssistant) ? GroupPage::where('grouppageID', $in['id'])->update(array('assistantID'=>Auth::user()->StudentID)) : '';
        }

    }
} 