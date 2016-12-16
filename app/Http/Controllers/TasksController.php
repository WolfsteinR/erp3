<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Task;
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
        $tasks = Task::orderBy('created_at')->paginate(0);
        return view('tasks')->withTasks($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $task = new Task;
        $task->name = $request->input('name');
        $task->author_id = $request->input('user_id');
        $task->body = $request->input('body');
        if($request->input('active') !== NULL)
        {
            $task->active = 1;
        }
        else
        {
            $task->active = 0;
        }
        $task->save();
        return redirect('/admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $task = Task::where('author_id', $id)->first();
        //$websites = 1;
        //$websites = Task::with('Company')->paginate(0);
        //$websites = DB::select('select * from user_in_company where id_user = :id_user', ['id_user' => $id]);
        $query = DB::select('select id_company from user_in_company where id_user = ? limit 1', [$id]); //клиент ведет одну фирму с одним сайтом, поэтому получаем только один сайт
        $company = Company::where('id', $query[0]->id_company)->first();
        return view('forms.task_form', ['link'=>'update-task', 'task'=>$task, 'company'=>$company]);
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
        $task = Task::where('author_id', $id)->first();
        if(!empty($request->input('name')))
        {
            $task->name = $request->input('name');
        }

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
