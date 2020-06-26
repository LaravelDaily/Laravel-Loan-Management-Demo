<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanApplicationRequest;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\LoanApplication;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanApplicationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplications = LoanApplication::all();

        return view('admin.loanApplications.index', compact('loanApplications'));
    }

    public function create()
    {
        abort_if(Gate::denies('loan_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analysts = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cfos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loanApplications.create', compact('analysts', 'cfos'));
    }

    public function store(StoreLoanApplicationRequest $request)
    {
        $loanApplication = LoanApplication::create($request->all());

        return redirect()->route('admin.loan-applications.index');
    }

    public function edit(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analysts = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cfos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loanApplication->load('status', 'analyst', 'cfo', 'created_by');

        return view('admin.loanApplications.edit', compact('analysts', 'cfos', 'loanApplication'));
    }

    public function update(UpdateLoanApplicationRequest $request, LoanApplication $loanApplication)
    {
        $loanApplication->update($request->all());

        return redirect()->route('admin.loan-applications.index');
    }

    public function show(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->load('status', 'analyst', 'cfo', 'created_by');

        return view('admin.loanApplications.show', compact('loanApplication'));
    }

    public function destroy(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanApplicationRequest $request)
    {
        LoanApplication::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
