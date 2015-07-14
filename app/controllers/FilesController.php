<?php
/**
 * Created by PhpStorm.
 * User: Gipoy17
 * Date: 12/24/2014
 * Time: 4:56 PM
 */

class FilesController extends BaseController {

    public function index() {
        $folders = FilesFolder::where('OwnerID', Auth::user()->StudentID)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        $files = Files::where('OwnerID', Auth::user()->StudentID)->where('delFlag', 0)->where('folderID', 0)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.files.index', compact('folders', 'files'));
    }
    public function addFiles($id) {
        $files = Input::file('files');

        foreach($files as $file) {
            $rules = array(
                'file' => FileTypes::getAllFileTypes()
            );

            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->passes()) {
                $randomId = Str::random(14);

                $destinationPath = 'uploads/files/'. Auth::user()->StudentID.'/';
                $filename =$file->getClientOriginalName();
                $mime_type = $file->getMimeType();
                $extension = $file->getClientOriginalExtension();
                $upload_success = $file->move('public/'.$destinationPath,  $randomId.$filename);
                if($upload_success) {
                    Files::create([
                        'OwnerID' => Auth::user()->StudentID,
                        'filename' => $filename,
                        'folderID' => $id,
                        'path' => $destinationPath.$randomId.$filename
                    ]);
                    return Redirect::to('/')->with('message','Files uploaded successfully')->with('url','');
                }
                return Redirect::to('/')->with('message','Error in uploading your files')->with('url','');
            }
            return Redirect::to('/')->with('message','Make sure you have files chosen')->with('url','');
        }
    }

    public function addFolder() {
        return View::make('validated.files.addFolder');
    }

    public function doAddFolder() {
       $in = Input::all();
        $rules = [
            'name' => 'required',
            'desc' => 'required'
        ];
        $validation = Validator::make($in, $rules);
        if($validation->passes()) {
            $check = FilesFolder::create([
                'name' => $in['name'],
                'description' => $in['desc'],
                'OwnerID' => Auth::user()->StudentID
            ]);
            return $check ?
                Redirect::to('/')->with('message','Folder successfully created.')->with('url','')
                :
                Redirect::to('/')->with('message','Error Folder not successfully created.')->with('url','');
        }
        Redirect::to('/')->with('message','Error Folder not successfully created.')->with('url','');
    }

    public function viewFolder($id) {
        $folder = FilesFolder::where('delFlag', 0)->find($id);
        $files = Files::where('folderID', $id)->where('delFlag', 0)->orderBy('created_at', 'DESC')->get();
        return View::make('validated.files.viewFolder', compact('folder', 'files'));
    }
    public function shareFile($id) {
        $file = Files::find($id);
        $groups = GroupPage::where('StudentID', Auth::user()->StudentID)->get();
        return View::make('validated.grouppage.shareFile', compact('file', 'groups'));
    }
    public function doShareFile($id) {
        $in = Input::all();
        $file = Files::find($id);
        foreach($in['groups'] as $group) {
            $gpPost = GroupPagePost::create([
                'grouppageID' => $group,
                'StudentID' => Auth::user()->StudentID,
                'Message' => strlen($in['message']) > 0 ? $in['message'] : 'shared a file.'
            ])->id;
            $groupPageFiles = GroupPageFiles::create([
                'path' => $file->path,
                'filename' => $file->filename,
                'grouppagepostID' => $gpPost,
                'OwnerID' => Auth::user()->StudentID
            ]);
        }
        return Redirect::to('/')->with('message', 'File successfully shared on you groups');
    }

    public function deleteFile($id) {
        $file = Files::find($id);
        if($file->OwnerID == Auth::user()->StudentID) {
            Files::whereId($id)->update(array('delFlag'=>1));
            return Redirect::back()->with('message', 'File successfully deleted.');
        }
        return Redirect::back()->with('message', 'Error accessing file.');
    }
    public function deleteFileFolder($id) {
        $folder = FilesFolder::find($id);
        if(Auth::user()->StudentID == $folder->OwnerID) {
            FilesFolder::find($id)->update(array('delFlag'=> 1)) ? Files::where('folderID', $id)->update(array('delFlag'=> 1)) : '';
        }


    }
} 