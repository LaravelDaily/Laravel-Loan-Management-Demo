<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\Http\Resources\Admin\LoanApplicationResource;
use App\LoanApplication;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanApplicationsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanApplicationResource(LoanApplication::with(['status', 'analyst', 'cfo', 'created_by'])->get());
    }

    public function store(StoreLoanApplicationRequest $request)
    {
        $loanApplication = LoanApplication::create($request->all());

        return (new LoanApplicationResource($loanApplication))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanApplicationResource($loanApplication->load(['status', 'analyst', 'cfo', 'created_by']));
    }

    public function update(UpdateLoanApplicationRequest $request, LoanApplication $loanApplication)
    {
        $loanApplication->update($request->all());

        return (new LoanApplicationResource($loanApplication))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
