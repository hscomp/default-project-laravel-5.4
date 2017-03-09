<?php

namespace App\Http\Requests\Auth;

use App\Forms\UserRegisterForm;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return (new UserRegisterForm('create'))->getRules();
            }
            case 'PUT':
            case 'PATCH': {
                return (new UserRegisterForm('edit'))->getRules();
            }
            default:
                break;
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /*
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
            */
        });
    }
}
