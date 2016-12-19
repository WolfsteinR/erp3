<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Html\FormFacade;
use Validator;
use Response;
use Redirect;
use Session;
use App\Uploads;

class UploadsController extends Controller
{
    public function index() {
        return view('upload.index');
    }
    public function multiple_upload() {
        $files = Input::file('images');
        $file_count = count($files);
        $uploadcount = 0;

        foreach ($files as $file) {
            $rules = array('file' => 'required');
            $validator = Validator::make(array('file'=>$file), $rules);
            if($validator->passes()){
                $destinationPath = 'uploads'; //upload folder in public directory
                $filename = $file->getClientOriginalName();
                $upload_success = $file->move($destinationPath, $filename);
                $uploadcount ++;

                //save into database
                $extension = $file->getClientOriginalExtension();
                $entry = new Uploads();
                $entry->mime = $file->getClientMimeType();
                $entry->original_filename = $filename;
                $entry->filename = $file->getFilename().'.'.$extension;
                $entry->save();
            }
        }
        if($uploadcount == $file_count) {
            Session::flash('success', 'Upload successfully');
            return Redirect::to('upload');
        }
        else {
            return Redirect::to('upload')->withInput()->withErrors($validator);
        }
    }
}
