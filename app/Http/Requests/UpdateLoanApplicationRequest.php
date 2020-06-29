<?php

namespace App\Http\Requests;

use App\LoanApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateLoanApplicationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(
            Gate::denies('loan_application_edit') || !in_array($this->route()->loan_application->status_id, [6, 7]),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        return true;
    }

    public function rules()
    {
        return [
            'loan_amount' => [
                'required',
            ],
        ];
    }
}
