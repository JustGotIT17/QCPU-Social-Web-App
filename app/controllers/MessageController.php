<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/8/2014
 * Time: 11:12 AM
 */

class MessageController extends BaseController{

    public function index() {
        $messages = Message::with('sender', 'owner')->where('DelFlag', 0)->where('RecipientID', Auth::user()->StudentID)->groupBy('SenderID')
            ->orderBy('created_at', 'DESC')->get();
        $myGroups = GroupChat::where('StudentID', Auth::user()->StudentID)->orderBy('created_at', 'DESC')->get();
        $groups = GroupChatMember::with('groupChat')->where('StudentID', Auth::user()->StudentID)->where('AddedByID', '!=', Auth::user()->StudentID)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.messages', compact('personal','messages', 'myGroups', 'groups'));

    }

    public function view($id) {
        $user = User::where('StudentID', $id)->first();
        $messages = Message::with('sender')->where('DelFlag', 0)->where(function($q) use($id) {
            $q->where('RecipientID', Auth::user()->StudentID)->where('SenderID', $id)->orWhere('RecipientID', $id)->where('SenderID', Auth::user()->StudentID);
        })->orderBy('created_at', 'DESC')->paginate(10);
        return View::make('validated.message.personal.view', compact('messages', 'user'));
    }

    public function personalReply($id) {
        $in = Input::all();
        Message::create([
           'RecipientID' => $id,
            'SenderID' =>Auth::user()->StudentID,
            'Message' => $in['message']
        ]);
        return '';
    }
    public function myGroupReply($id) {
        $in = Input::all();
        GroupChatMessage::create([
            'GCID' => $id,
            'StudentID' =>Auth::user()->StudentID,
            'Message' => $in['message']
        ]);
        return '';
    }
    public function personalDelete($id) {
        $message = Message::find($id);
        $message->DelFlag = 1;
        $message->save();
    }
    public function myGroupView($id) {
        $groupChat = GroupChat::where('ID', $id)->first();
        $messages = GroupChatMessage::with('owner')->where('GCID', $id)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.message.mygroup.view', compact('messages', 'id', 'groupChat'));
    }

    public function groupView($id) {
        $groupChat = GroupChat::where('ID', $id)->first();
        $messages = GroupChatMessage::with('owner')->where('GCID', $id)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.message.group.view', compact('messages', 'id', 'groupChat'));
    }
    public function myGroupCreate() {
        $in = Input::all();
        $result = GroupChat::create([
            'Name' => (strlen($in['name']) < 1) ? 'No name [' . date('m-d-Y') .'-' . time(). ']' : $in['name'],
            'StudentID' => Auth::user()->StudentID
        ]);
        GroupChatMember::create([
            'GCID' => $result->id,
            'StudentID' => Auth::user()->StudentID,
            'addedByID' => Auth::user()->StudentID
        ]);
        GroupChatMessage::create([
            'GCID' => $result->id,
            'StudentID' =>Auth::user()->StudentID,
            'Message' => Auth::user()->Firstname . ' ' . Auth::user()->Lastname . ' created this group chat.'
        ]);
        return Redirect::to('/')->with('message', 'Group chat successfully created')->with('url', '');
    }
    public function myGroupSearchPeople($id) {
        $in = Input::all();
        $name = $in['name'];
        if(strlen($name) < 1)
            return '';

        $users = User::with('course' ,'groupChatMember')->where('StudentID','!=', Auth::user()->StudentID)->where(function($q) use($name){
            $q->where('StudentID', 'LIKE', '%'.$name.'%')->orWhere('Lastname', 'LIKE', '%'.$name.'%')->orWhere('Firstname', 'LIKE', '%'.$name.'%')->get();
        })->paginate(10);
        return View::make('validated.message.mygroup.search', compact('users', 'id'));
    }
    public function myGroupAddPeople($id, $StudentID) {
        $userToBeAdded = User::getUser($StudentID);
        if(!GroupChatMember::alreadyMember($id, $StudentID)) {
            GroupChatMember::create([
                'GCID' => $id,
                'StudentID' => $StudentID,
                'addedByID' => Auth::user()->StudentID
            ]);
            GroupChatMessage::create([
                'GCID' => $id,
                'StudentID' => Auth::user()->StudentID,
                'Message' => 'I added ' . $userToBeAdded->Firstname . ' ' . $userToBeAdded->Lastname . ' to this group chat.'
            ]);
        }
    }
    public function groupDelete($id) {
        $message = GroupChatMessage::where('ID',$id)->first();
        if(count($message) && Auth::user()->StudentID == $message->StudentID) {
            GroupChatMessage::where('ID',$id)->update(['delFlag' => 1]);
            return "okay";
        }
    }

    public function groupAddMember($id) {
        $groupChat = GroupChat::where('ID', $id)->first();
        return View::make('validated.message.addMember', compact('groupChat','id'));
    }
    public function groupMembers($gcid) {
        $groupChat = GroupChat::where('ID', $gcid)->first();
        $members = GroupChatMember::with('activeUsers')->where('delFlag', 0)->where('GCID', $gcid)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.message.members', compact('groupChat', 'members'));
    }

    public function groupDeleteMember($gcid) {
        $in = Input::all();
        $groupChat = GroupChat::where('ID', $gcid)->first();
        if($groupChat->StudentID == Auth::user()->StudentID) {
            GroupChatMember::where('GCID', $gcid)->where('StudentID', $in['AccID'])->update(['delFlag'=>1]);
            return 'ok';
        }
    }
}