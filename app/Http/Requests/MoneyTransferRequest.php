<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MoneyTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payerAccount' => [
                'required',
                'min:6',
                'max:22',
                Rule::exists('accounts', 'account_no')->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'recipientAccount' => 'required',
            'amount' => 'required|numeric|min:1'
        ];
    }
}
