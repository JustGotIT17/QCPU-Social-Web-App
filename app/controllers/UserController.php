<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/9/2014
 * Time: 10:50 AM
 */

class UserController extends BaseController {

    public function online() {
        User::updateLastSeen();
        $online = User::getAllOnlineUsers();
        return View::make('layouts.onlineUsers', compact('online'));
    }

    public function profile($id) {
        $user = User::with('gender', 'course', 'userType')->where('StudentID',$id)->first();
        $courses = Course::all()->lists('CourseAbbr', 'CourseID');
        $genders = Gender::all()->lists('Gender', 'GenderID');
        return View::make('validated.profile.edit', compact('user', 'courses', 'genders'));
    }

    public function updatePersonal() {
        $in = Input::all();
        $rule = [
            'nickname' => 'required'
        ];
        $validation = Validator::make($in, $rule);
        if($validation->passes()) {
            User::where('StudentID', Auth::user()->StudentID)->update(array('nickname'=> $in['nickname']));
            return Redirect::to('/')->with('message', 'Account information successfully updated.')->with('url', '/profile/'.Auth::user()->StudentID);
        }

        return Redirect::to('/')->with('message', 'Error in updating account information.')->with('url', '/profile/'.Auth::user()->StudentID);
    }

    public function updateSecurity() {
        $in = Input::all();
        $rules = [
            'pass' => 'required',
            'newpass' => 'required',
            'conpass' => 'required|same:newpass'
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            return Hash::make($in['newpass']);
            if (Hash::check($in['newpass'], Auth::user()->password)) {
                $password = Hash::make($in['newpass']);
                User::where('StudentID', Auth::user()->StudentID)->update(array('password'=> $password));
                return Redirect::to('/')->with('message', 'Account information successfully updated.')->with('url', '/profile/'.Auth::user()->StudentID);
            }
        }

        return Redirect::to('/')->with('message', 'Error in updating account information.')->with('url', '/profile/'.Auth::user()->StudentID);
    }

} 