<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/3/2014
 * Time: 10:56 AM
 */

class AppController extends BaseController {

    public function index() {
        return View::make('layouts.default');
    }

    public function showRegister() {
        return Redirect::to('/');
        return View::make('register');
    }
    public function doRegister() {
        return Redirect::to('/');
        $in = Input::all();
        User::create([
           'StudentID' => $in['studentID'],
            'Password' => Hash::make($in['password']),
            'Lastname' =>'Last-name',
            'Firstname' =>'First-name',
            'GenderID' =>'1',
            'CourseID' =>'1',
            'online' =>'0',
            'Description' =>'okay',
            'photo' =>'unknown.jpg',
            'chatfavorite' =>'1'

        ]);
    }
    public function showLogin() {
        return View::make('login');
    }
    public function doLogin() {
        $in = Input::all();
        $user = array(
            'AccountID' => $in['AccountID'],
            'password' => $in['password']
        );
        $rules = array(
            'AccountID'  => 'Required|min:7|max:7',
            'password'  => 'Required|min:6|max:20',
        );
        $validator = Validator::make($user, $rules);
        if ($validator->passes()) {
            $check = User::where('StudentID',$in['AccountID'])
                ->where('lastSeen', '>=', date_sub(date_create(MyDate::getNormalDateFormat()), date_interval_create_from_date_string("1 minute")))->first();
            if(!count($check)) {
                $user = array(
                    'StudentID' => $in['AccountID'],
                    'password' => $in['password']
                );
                if (Auth::attempt($user)) {
                    User::updateLastSeen();
                    User::addLoginRecord();
                    return Redirect::to('/');
                }
                else
                    return Redirect::back()->withErrors(array('password' => 'Account ID and Password not matched'))->withInput(Input::except('password'));
            } else

                return Redirect::back()->withErrors(array('password'=>'Your account is currently online. Multiple login session is not allowed.'))->withInput(Input::except('password'));
        }
        return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
    }
    public function logout() {
        Auth::logout();
        return Redirect::to('/login');
    }

    public function favorites() {
        $favorites = Favorite::with('users')->where('StudentID', Auth::user()->StudentID)->where('favorite', 1)->get();
        return View::make('validated.favorites', compact('favorites'));
    }

    public function more() {
        $user = User::with('Course', 'Gender','userType')->where('StudentID', Auth::user()->StudentID)->first();
        $adminGroupPages = GroupPage::where('StudentID', Auth::user()->StudentID)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        $groupPages = GroupPageMember::with('groupPages')->where('StudentID', Auth::user()->StudentID)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();

        if(Auth::user()->UserTypeID == 2) {
            $files = Files::where('delFlag', 0)->where('folderID', 0)->where('OwnerID', Auth::user()->StudentID)->get();
            $fileFolders = FilesFolder::where('OwnerID', Auth::user()->StudentID)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
            $activities = GroupPageActivity::where('OwnerID', Auth::user()->StudentID)->where('delFlag', 0)->get();
            $quizzes = Quiz::where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        }
        else {
            $activities = GroupPageActivityGroup::with('groupPage', 'groupPageActivityFiles')->where('deadline', '>', date('Y-m-d H:i:s'))->whereExists(function($q) {
                $q->select(DB::raw(0))->from('grouppagemember')->whereRaw('grouppagemember.grouppageID = grouppageactivitygroup.grouppageID')
                    ->where('StudentID', Auth::user()->StudentID)->whereRaw('grouppagemember.delFlag = 0');
            })->orderBy('deadline', 'ASC')->get();
            $quizzes = QuizGroupPage::with('groupPageMember','groupPage', 'quiz')->where('delFlag', 0)->whereNotExists(function($q){
                $q->select(DB::raw(0))->from('quiztaken', 'grouppagemember')->where('quiztaken.OwnerID', Auth::user()->StudentID)
                    ->whereRaw('quiztaken.quizID = quizgrouppage.quizID')->where('delFlag', 0);
            })->get();
        }

        return View::make('validated.more', compact('user','adminGroupPages' ,'groupPages', 'files', 'fileFolders', 'activities', 'quizzes'));
    }

}