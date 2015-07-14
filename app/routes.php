<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['before'=>'guest'], function() {
    Route::get('/login', 'AppController@showLogin');
    Route::post('/login', 'AppController@doLogin');
    Route::get('/register', 'AppController@showRegister');
    Route::post('/register', 'AppController@doRegister');
});
Route::group(['before'=>'auth'], function(){
    Route::get('/', 'AppController@index');

    Route::get('/logout', 'AppController@logout');

    Route::get('/profile/{id}', 'UserController@profile');

    Route::get('/search', 'SearchController@index');
    Route::post('/search', 'SearchController@search');

    Route::get('/users/online', 'UserController@online');
    Route::post('/users/update/personal', 'UserController@updatePersonal');
    Route::post('/users/update/security', 'UserController@updateSecurity');

    Route::get('/notification', 'NotificationController@notifications');
    Route::get('/notification/new/{id}', 'NotificationController@newNotifications');


    Route::get('/newsfeed', 'NewsFeedController@newsFeed');
    Route::get('/newsfeed/new/posts/{id}', 'NewsFeedController@newPosts');

    Route::get('/post/status', 'PostStatusController@getPostStatus')->before('role:1');
    Route::post('/post/status', 'PostStatusController@postStatus')->before('role:1');
    Route::get('/post/star/{id}', 'PostStatusController@postStar');
    Route::get('/post/comments/{id}', 'PostStatusController@getPostComments');
    Route::post('/post/comments/{id}', 'PostStatusController@postComments');
    Route::get('/post/edit/{id}', 'PostStatusController@edit');
    Route::post('/post/save/{id}', 'PostStatusController@save');
    Route::get('/post/remove/{id}', 'PostStatusController@remove');

    Route::get('/messages', 'MessageController@index');
    Route::get('/messages/view/{id}', 'MessageController@view');
    Route::post('/messages/personal/reply/{id}', 'MessageController@personalReply');
    Route::post('/messages/personal/delete/{id}', 'MessageController@personalDelete');
    Route::post('/messages/mygroup/create/', 'MessageController@myGroupCreate');
    Route::get('/messages/mygroup/{id}/add/{StudentID}', 'MessageController@myGroupAddPeople');
    Route::post('/messages/mygroup/{id}/search', 'MessageController@myGroupSearchPeople');
    Route::get('/messages/mygroup/view/{id}', 'MessageController@myGroupView');
    Route::post('/messages/mygroup/reply/{id}', 'MessageController@myGroupReply');
    Route::get('/messages/group/view/{id}', 'MessageController@groupView');
    Route::post('/messages/group/delete/{id}', 'MessageController@groupDelete');
    Route::get('/messages/group/member/add/{gcid}', 'MessageController@groupAddMember');
    Route::get('/messages/group/member/{gcid}', 'MessageController@groupMembers');
    Route::post('/messages/group/member/delete/{gcid}', 'MessageController@groupDeleteMember');

    Route::get('/favorites', 'AppController@favorites');
    Route::get('/favorites/add/{id}', 'FavoriteController@add');
    Route::get('/favorites/remove/{id}', 'FavoriteController@remove');

    Route::get('/files', 'FilesController@index')->before('role:2');
    Route::post('/files/add/{id}', 'FilesController@addFiles')->before('role:2');
    Route::get('/files/folder/add', 'FilesController@addFolder')->before('role:2');
    Route::post('/files/folder/add', 'FilesController@doAddFolder')->before('role:2');
    Route::get('/files/folder/view/{id}', 'FilesController@viewFolder')->before('role:2');
    Route::get('/files/share/{id}', 'FilesController@shareFile')->before('role:2');
    Route::post('/files/share/{id}', 'FilesController@doShareFile')->before('role:2');
    Route::post('/files/delete/{id}', 'FilesController@deleteFile')->before('role:2');
    Route::post('/files/folder/delete/{id}', 'FilesController@deleteFileFolder')->before('role:2');


    Route::get('/more', 'AppController@more');


    Route::get('/grouppage/view/{id}', 'GroupPageController@view');
    Route::get('/grouppage/join/{id}', 'GroupPageController@askJoin');
    Route::get('/grouppage/join/accept/{id}', 'GroupPageController@acceptJoin');
    Route::post('/grouppage/user/search/', 'GroupPageController@searchAssistant');
    Route::post('/grouppage/assign/assistant', 'GroupPageController@changeAssistant')->before('role:2');
    Route::get('/grouppage/post/{id}', 'GroupPageController@postToWall');
    Route::post('/grouppage/post/star', 'GroupPageController@starPost');
    Route::post('/grouppage/post/{id}', 'GroupPageController@postMessage');
    Route::post('/grouppage/post/comment/delete', 'GroupPageController@deletePostComment');
    Route::post('grouppage/comment/post', 'GroupPageController@addCommentToPost');
    Route::post('/grouppage/post/{id}/delete', 'GroupPageController@postDeleteMessage');
    Route::get('/grouppage/{id}/post/{pid}/comment/', 'GroupPageController@displayPostComment');
    Route::get('/grouppage/view/activity/{gid}/{id}', 'GroupPageController@viewActivity');
    Route::get('/grouppage/view/activities/{id}', 'GroupPageController@viewActivities');
    Route::get('/grouppage/view/people/{id}', 'GroupPageController@viewAddPeople');
    Route::get('/grouppage/view/settings/{id}', 'GroupPageController@viewSettings');
    Route::post('/grouppage/search/addpeople', 'GroupPageController@searchAddPeople');
    Route::post('/grouppage/search/add', 'GroupPageController@addPeople');
    Route::post('/grouppage/delete', 'GroupPageController@delete');
    Route::post('/grouppage/leave/force', 'GroupPageController@forceLeave');
    Route::post('/grouppage/leave/', 'GroupPageController@leave');
    Route::get('/grouppage/addGroupPage', 'GroupPageController@addGroupPage')->before('role:2');
    Route::post('/grouppage/addGroupPage', 'GroupPageController@postAddGroupPage')->before('role:2');
    Route::post('/grouppage/files/add/{id}', 'GroupPageController@addFiles');

    Route::get('/group/activities/addActivities', 'GroupActivityController@addActivity')->before('role:2');
    Route::post('/group/activities/add', 'GroupActivityController@createActivity')->before('role:2');
    Route::get('/group/activities/view/{id}', 'GroupActivityController@viewActivity')->before('role:2');
    Route::post('/group/activities/submit/{id}', 'GroupActivityController@submitFile');
    Route::get('/group/activities/view/designation/{acid}', 'GroupActivityController@viewDesignation')->before('role:2');
    Route::get('/group/activities/view/submission/{acgid}/{acid}', 'GroupActivityController@viewSubmission')->before('role:2');
    Route::get('/group/activities/view/settings/{acid}', 'GroupActivityController@viewSettings')->before('role:2');
    Route::post('/group/activities/designation/submit', 'GroupActivityController@createDesignation')->before('role:2');

    Route::get('/quiz/create', 'QuizController@createQuiz')->before('role:2');
    Route::post('/quiz/create', 'QuizController@addQuiz')->before('role:2');
    Route::get('/quiz/view/{qid}', 'QuizController@viewQuiz')->before('role:2');
    Route::get('/quiz/view/student/{quizID}/{groupPageID}', 'QuizController@viewQuizByStudent');
    Route::get('/quiz/take/student/{quizID}/{groupPageID}', 'QuizController@takeQuizByStudent');
    Route::post('/quiz/take/student/{quizID}', 'QuizController@submitQuizByStudent');
    Route::get('/quiz/settings/{qid}', 'QuizController@settings')->before('role:2');
    Route::get('/quiz/question/create/{qid}', 'QuizController@createQuestion')->before('role:2');
    Route::get('/quiz/question/edit/{qid}', 'QuizController@editQuestion')->before('role:2');
    Route::post('/quiz/question/save/{qid}', 'QuizController@updateQuestion')->before('role:2');
    Route::post('/quiz/question/create/{qid}', 'QuizController@addQuestion')->before('role:2');
    Route::post('/quiz/question/delete/{qid}', 'QuizController@deleteQuestion')->before('role:2');
    Route::get('/quiz/view/designation/{qid}', 'QuizController@viewDesignation')->before('role:2');
    Route::get('/quiz/view/result/{quizID}/{quizGroupPageID}', 'QuizController@viewQuizResult')->before('role:2');
    Route::post('/quiz/view/designation/{qid}', 'QuizController@addDesignation')->before('role:2');
    Route::post('/quiz/delete/designation/{qid}', 'QuizController@deleteDesignation')->before('role:2');

    Route::get('/uploads/files/{StudentID}/{reqFile}', 'DownloadFileController@downloadMyFilesFile');
    Route::get('/uploads/grouppage/files/{id}/{StudentID}/{reqFile}', 'DownloadFileController@downloadGroupPageFile');

});
