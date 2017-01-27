<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\User;
use App\Company;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = '';
        if(Auth::user()->role == 'client') {
            //видит свои задачи
            $tasks = Task::where('author_id', Auth::user()->id)->paginate(0);
        }
        elseif(Auth::user()->role == 'manager') {
            $companys_id = array();
            $users_id = array();
            //$tasks = array();
            $companys_id = DB::select('select id_company from user_in_company where id_user = ?', [Auth::user()->id]);
            foreach ($companys_id as $cid) {
                $users_id[] = DB::select('select id_user from user_in_company where id_company = ?', [$cid->id_company]);
            }

            $i = 0;
            $uids = array();
            foreach ($users_id as $uid) {
                $uids[] = $uid[$i]->id_user;
                $i++;
            }

            //foreach ($users_id as $uid) {
                $tasks = Task::whereIn('author_id', $uids)->leftJoin('users', 'users.id', '=', 'tasks.spec_id')->paginate(0);
            //print '<pre>';print_r($tasks);exit;
                //$i++;
            //}
        }
        elseif(Auth::user()->role == 'specialist') {
            // получим задачи, назначенные специалисту
            $tasks = Task::where('spec_id', Auth::user()->id)->get();
        }
        //$tasks = Task::orderBy('created_at')->paginate(0);
        return view('tasks')->withTasks($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('forms.task_form', ['link'=>'create-task']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // translit for slug
        function rus2translit($string) {
            $converter = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'y',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
                'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
                'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            );
            return strtr($string, $converter);
        }

        $files = Input::file('images');
        if($files != '') {
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
                //return Redirect::to('upload');
            }
            //else {
                //return Redirect::to('upload')->withInput()->withErrors($validator);
            //}
        }

        $task = new Task;
        $task->title = $request->input('title');
        $task->author_id = $request->input('user_id');
        $task->body = $request->input('body');
        $task->website = $request->input('website');
        $task->slug = str_slug(strtolower(rus2translit($request->input('title'))), '-');
        if($request->input('active') !== NULL)
        {
            $task->active = 1;
        }
        else
        {
            $task->active = 0;
        }
        $task->priority = $request->input('priority');
        if(isset($file_count) && $file_count != 0) {
            $task->upload_id = $entry->id;
        }
        $task->save();
        return redirect('/admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $id - это должен быть id задачи, но сейчас это id менеджера и в форму подгружается адрес его сайта
        // Тут нужно разделение - создаем новую задачу, значит link - create-task А если открыли уже текущую, передаем сюда id задачи и подгружаем данные в форму, link будет update-task
        //$task = Task::where('author_id', $id)->first();
        //$websites = 1;
        //$websites = Task::with('Company')->paginate(0);
        //$websites = DB::select('select * from user_in_company where id_user = :id_user', ['id_user' => $id]);
        $task = '';
        $link = 'create-task';
        $specialists = '';
        if(!empty($id)) {
            $task = Task::where('id', $id)->first();
            $link = 'update-task';
        }
        // If user role is manager, then loading specialists from database
        if(Auth::user()->role == 'manager') {
            $specialists = User::where('role', 'spec')->paginate(0);
        }
        $query = DB::select('select id_company from user_in_company where id_user = ? limit 1', [Auth::user()->id]); //клиент ведет одну фирму с одним сайтом, поэтому получаем только один сайт
        $company = Company::where('id', $query[0]->id_company)->first();
        return view('forms.task_form', ['link'=>$link, 'task'=>$task, 'company'=>$company, 'specialists'=>$specialists]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->first();
        //if(!empty($request->input('title')))
        //{
            $task->title = $request->input('title');
            $task->body = $request->input('body');
            $task->website = $request->input('website');
            if($request->input('active') !== NULL)
            {
                $task->active = 1;
            }
            else
            {
                $task->active = 0;
            }
            $task->priority = $request->input('priority');
            if($request->input('spec') != '') {
                $task->spec_id = $request->input('spec');
            }
        // обновлять updated_at
        //}

        $task->save();
        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
