<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Company;
use App\User;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$companies = Company::orderBy('created_at')->paginate(0);
        $companies = Company::with('User')->paginate(0);
        return view('companies')->withCompanies($companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $company = new Company;
        $company->name = $request->input('name');
        $company->website = $request->input('website');
        //$company->client_id = $request->input('user_id');
        $company->save();
        DB::insert('insert into user_in_company (id_company, id_user) values (?, ?)', [$company->id, $request->input('user_id')]);

        Mail::send('emails.new_company', ['name' => $company->name, 'message' => 'Message'], function ($message) use ($company)
        {
            $message->from('wolfsz@yandex.ru', 'Test.ERP');
            $message->to($company->email);
        }); // send email about new company in ERP system
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::where('client_id', $id)->first();
        return view('forms.company_form', ['link'=>'update-company', 'company'=>$company]);
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
        $company = Company::where('client_id', $id)->first();
        if(!empty($request->input('name')))
        {
            $company->name = $request->input('name');
        }
        if(!empty($request->input('website')))
        {
            $company->website = $request->input('website');
        }

        $company->save();
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

    /* Form add manager to company */
    public function form_add_manager_to_company()
    {
        $managers = User::where('role', 'manager')->paginate(0);
        $companies = Company::orderBy('created_at')->paginate(0); //выводить только формы без менеджеров???
        return view('forms.add_manager_to_company', ['managers'=>$managers, 'companies'=>$companies]);
    }
    /* Add manager to company */
    public function add_manager_to_company()
    {

    }
}
