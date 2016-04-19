<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\UserCompany;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $company = Company::paginate(15);

        return view('company.index', compact('company'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $this->createCompany();

        Session::flash('flash_message', 'Company added!');
        return redirect('company');
    }

    public function createCompany(array $company){
//        $this->validate($request->input('company'), ['company_name' => 'required', 'company_description' => 'required', ]);
        return Company::create($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);

        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['company_name' => 'required', 'company_description' => 'required', ]);

        $company = Company::findOrFail($id);
        $company->update($request->all());

        Session::flash('flash_message', 'Company updated!');

        return redirect('company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Company::destroy($id);

        Session::flash('flash_message', 'Company deleted!');

        return redirect('company');
    }

    public function attachUser($user, $company){
        return DB::table('user_company')->insert(
            array('user_id' => $user->id, 'company_id' => $company->id)
        );
    }

}
