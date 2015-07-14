<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 1/29/2015
 * Time: 11:38 PM
 */

class QuizController extends BaseController{

    public function createQuiz() {
        return View::make('validated.quiz.create');
    }

    public function addQuiz() {
        $in = Input::all();
        $rules = [
            'name' =>'required',
            'topic' => 'required'
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()){
            $quiz = Quiz::create([
                'name'=>$in['name'],
                'OwnerID'=>Auth::user()->StudentID,
                'quizTopic'=>$in['topic']
            ])->id;
            return Redirect::to('/')->with('message', 'Quiz successfully created')->with('url', '/quiz/view/'.$quiz);
        }
        return Redirect::to('/')->with('message', 'Error quiz creation. Click view to create again')->with('url', '/quiz/create/');
    }

    public function viewQuiz($id) {
        $quiz = Quiz::where('delFlag', 0)->find($id);
        $quizItems = QuizItem::with('quizItemChoices', 'quizItemAnswer')->where('delFLag', 0)->where('quizID', $id)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.quiz.view', compact('quiz', 'quizItems'));
    }

    public function viewQuizByStudent($qid, $gid) {
        $quiz = QuizGroupPage::with('quiz', 'groupPage', 'owner')->where('quizID', $qid)->where('grouppageID', $gid)->where('delFLag', 0)->first();
        return View::make('validated.quiz.viewByStudent', compact('quiz'));
    }

    public function takeQuizByStudent($qid, $gid) {
        $check = QuizTaken::where('OwnerID', Auth::user()->StudentID)->where('quizID', $qid)->where('delFlag',0)->first();
        if(!count($check)) {
            /*
            QuizTaken::create([
                'OwnerID' => Auth::user()->StudentID,
                'quizID' => $qid
            ]);*/
            $quiz = QuizGroupPage::with('quiz')->where('delFlag', 0)->where('quizID',$qid)->where('grouppageID',$gid)->first();
            $quizItems = QuizItem::with('quizItemChoices', 'quizItemAnswer')->where('delFLag', 0)->where('quizID', $qid)->orderBy(DB::raw('RAND()'))->get();
            return View::make('validated.quiz.take', compact('quiz', 'quizItems'));
        }
        return Redirect::to('/')->with('message', 'You have already taken the quiz')->with('url', '');
    }

    public function submitQuizByStudent($quizGroupPageID) {
        $qgp = QuizGroupPage::where('delFlag', 0)->find($quizGroupPageID);
        $qgp ? $qItems = QuizItem::where('delFlag', 0)->where('quizID', $qgp->quizID)->get() : Redirect::to('/')->with('message', 'Error in submitting quiz.')->with('url', '');
        $in = Input::all();
        $numOfCorrectAns = 0;

        foreach($in['item'] as $key=>$value) {
            QuizItemAnswer::checkAnswer($key, $value) ? $numOfCorrectAns++ : '';
        }

        QuizResult::create([
           'OwnerID' => Auth::user()->StudentID,
            'quizgrouppageID' => $quizGroupPageID,
            'score' => $numOfCorrectAns,
            'totalItems' => $qItems->count()
        ]);

        return Redirect::to('/')->with('message', 'Quiz has been successfully recorded')->with('url', '');
    }
    public function settings($id) {
        $quiz = Quiz::find($id);
        return View::make('validated.quiz.settings', compact('quiz'));
    }

    public function createQuestion($id) {
        $quiz = Quiz::find($id);
        $ans = [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D'
        ];

        return View::make('validated.quiz.createQuestion', compact('quiz', 'ans'));
    }
    public function addQuestion($id) {
        $in = Input::all();
        $rules = [
            'question' =>'required',
            'choiceA' =>'required',
            'choiceB' =>'required',
            'choiceC' =>'required',
            'choiceD' =>'required',
            'answer' =>'required',
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            $quizItemID = QuizItem::create([
                'question' => $in['question'],
                'quizID' => $id
            ])->id;
            QuizItemChoice::create([
                'choice1' =>$in['choiceA'],
                'choice2' =>$in['choiceB'],
                'choice3' =>$in['choiceC'],
                'choice4' =>$in['choiceD'],
                'quizItemID' => $quizItemID
            ]);
            QuizItemAnswer::create([
                'answer' => $in['answer'],
                'quizItemID' => $quizItemID
            ]);
            return Redirect::to('/')->with('message','Question successfully added')->with('url', '/quiz/view/'.$id);
        }
        else {
            return Redirect::to('/')->with('message','Error in adding question');
        }
    }

    public function viewDesignation($id){
        $quiz = Quiz::find($id);
//        $groups = GroupPage::where('StudentID', Auth::user()->StudentID)->where('delFlag', 0)->get();
        $groups = DB::table('grouppage')->where('StudentID', Auth::user()->StudentID)->where('delFlag', 0)->whereNotExists(function($query) use($id){
            $query->select(DB::raw(1))->from('quizgrouppage')->whereRaw('quizgrouppage.grouppageID = grouppage.grouppageID')
                ->whereRaw('quizgrouppage.quizID = '. $id)->where('delFlag', 0);
        })->orderBy('Name', 'ASC')->lists('Name', 'grouppageID');
        $designations = QuizGroupPage::with('groupPage', 'quiz')->where('OwnerID', Auth::user()->StudentID)->where('delFlag', 0)->get();
        return View::make('validated.quiz.designation', compact('quiz', 'groups', 'designations'));
    }

    public function addDesignation($id) {
        $in = Input::all();
        $rules = [
            'duration' => 'required|numeric|min:1'
        ];

        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            $qgp = QuizGroupPage::create([
                'quizID' => $id,
                'grouppageID' => $in['group'],
                'OwnerID' => Auth::user()->StudentID,
                'deadline' => $in['deadline']. ' ' .$in['time'],
                'duration' => $in['duration']
            ]);
            GroupPagePost::create([
                'grouppageID'=>$in['group'],
                'StudentID' => Auth::user()->StudentID,
                'Message' => '<h5>Activity name:</h5>Christmas Party<br/><h5>Description:</h5>Celebration<br/><span class="timeago">Deadline: '. $qgp->created_at .'</span><p>Kindly check your activities Tab</p>'
            ]);
            return Redirect::to('/')->with('message','Group quiz designated successfully')->with('url','/quiz/view/designation/'. $id);
        }

        return Redirect::to('/')->with('message', 'Error quiz designation');
    }
    public function deleteDesignation($id) {
        QuizGroupPage::find($id)->update(array('delFlag'=>1));
    }
    public function editQuestion($id) {
        $ans = [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D'
        ];
        $quizItem = QuizItem::with('quizItemChoices', 'quizItemAnswer')->where('delFLag', 0)->whereId($id)->first();
        $quiz = Quiz::find($quizItem->quizID);

        return View::make('validated.quiz.edit', compact('quizItem', 'quiz', 'ans'));
    }

    public function viewQuizResult($id, $quizGroupPageID) {
        $quiz = Quiz::with('groupPage')->find($id);
        $quizResults = QuizResult::with('owner')->where('quizgrouppageID', $quizGroupPageID)->raw('ORDER BY user.Lastname ASC')->get();
        return View::make('validated.quiz.viewResult', compact('quiz', 'quizResults'));
    }

    public function updateQuestion($id) {
        $quizItem = QuizItem::with('quizItemChoices', 'quizItemAnswer')->where('delFLag', 0)->whereId($id)->first();
        $in = Input::all();
        $rules = [
            'question' =>'required',
            'choiceA' =>'required',
            'choiceB' =>'required',
            'choiceC' =>'required',
            'choiceD' =>'required',
            'answer' =>'required',
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            QuizItem::find($id)->update(array('question'=>$in['question']));
            QuizItemAnswer::where('quizItemID', $id)->update(array('answer'=>$in['answer']));
            QuizItemChoice::where('quizItemID', $id)->update(array('choice1'=>$in['choiceA'], 'choice2'=>$in['choiceB'], 'choice3'=>$in['choiceC'],'choice4'=>$in['choiceD']));
            return Redirect::to('/')->with('message','Question successfully updated')->with('url', '/quiz/view/'.$quizItem->quizID);
        }
        else {
            return Redirect::to('/')->with('message','Error in updating question');
        }
    }
    public function deleteQuestion($id) {
        QuizItem::find($id)->update(array('delflag'=>1));
    }
} 