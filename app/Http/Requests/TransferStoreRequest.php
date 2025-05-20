<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TransferStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'account' => ['required', 'string'],
            'document' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Valor é obrigatório',
            'amount.numeric' => 'Valor deve ser numérico',
            'amount.min' => 'Valor deve ser maior que 0.01',
            'account.required' => 'Número da conta é obrigatório',
            'document.required' => 'Documento é obrigatório',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $account = $this->input('account');
                $document = $this->input('document');

                $userExists = User::where('account_number', $account)
                    ->where('document_number', $document)
                    ->exists();

                if (!$userExists) {
                    $validator->errors()->add(
                        'account',
                        'Usuário com essa conta e documento não foi encontrado.'
                    );
                }
            }
        ];
    }
}
