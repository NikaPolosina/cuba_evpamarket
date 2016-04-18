<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

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

        return view('company.company.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('company.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['company_name' => 'required', 'company_description' => 'required', ]);

        Company::create($request->all());

        Session::flash('flash_message', 'Company added!');

        return redirect('company');
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

        return view('company.company.show', compact('company'));
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

        return view('company.company.edit', compact('company'));
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

}
