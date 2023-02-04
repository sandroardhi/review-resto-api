<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                // ignore ini buat mengabaikan error pas ngeupdate id yang sama, jadi misale mau update resto kan nanti id nya tabrakan, dikasih ini biar ga eror dan tetep bisa disubmit, kyke owkkowkwo
                Rule::unique('restos', 'name')->ignore($this->route('restos.update')),
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
                'max:750',
            ],
            'address' => [
                'sometimes',
                'required',
                'string',
                'max:750',
            ]
        ];
    }
}
