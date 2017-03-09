<?php

namespace App\Forms;

class UserRegisterForm extends BaseForm
{
    /**
     * Get Form fields.
     *
     * @return array
     */
    public function fields()
    {
        $fields = [
            'first_name' => [
                'formType'          => 'create|edit',
                'fieldComponent'    => 'textField',
                'fieldType'         => 'text',
                'label'             => trans('words.first_name'),
                'attributes'        => ['class' => 'form-control petr marie', 'data-test' => 'ok'],
                'parentClass'       => 'col-md-6',
                'parentAttributes'  => ['jmeno' => 'zavicak'],
                'rules'             => 'required|min:2|max:50|name_characters',
            ],
            'last_name' => [
                'formType'          => 'create|edit',
                'fieldComponent'    => 'textField',
                'fieldType'         => 'text',
                'label'             => trans('words.last_name'),
                'attributes'        => ['class' => 'form-control petr marie', 'data-test' => 'ok'],
                'parentClass'       => 'col-md-6',
                'parentAttributes'  => ['jmeno' => 'zavicak'],
                'rules'             => 'required|min:2|max:50|name_characters',
            ],
            'email' => [
                'formType'          => 'create',
                'fieldComponent'    => 'textField',
                'fieldType'         => 'text',
                'label'             => trans('words.email'),
                'rules'             => 'required|min:3|max:255|email|unique:users',
            ],
            'password' => [
                'formType'          => 'create|edit',
                'fieldComponent'    => 'passwordField',
                'fieldType'         => 'password',
                'label'             => trans('words.password'),
                'rules'             => 'required|min:5|max:30|confirmed',
            ],
            'password_confirmation' => [
                'formType'          => 'create|edit',
                'fieldComponent'    => 'passwordField',
                'fieldType'         => 'password',
                'label'             => trans('words.password_confirmation'),
            ],
        ];

        return $fields;
    }

    public function url()
    {
        return [
            'create' => route('auth.registerAction'),
            'edit' => route('auth.registerAction'),
        ];
    }

    public function formClass()
    {
        return [
            'create' => 'form-horizontal',
            'edit' => 'form-horizontal',
        ];
    }

    public function formAttributes()
    {
        return [
            'edit' => ['jo', 'ne', 'pole' => 261],
            'create' => ['form-horizontal'],
        ];
    }

    public function submitButtonText($formType)
    {
        return [
            'create' => trans('words.create_account'),
            'edit' => trans('words.create_account'),
        ];
    }

    public function dataRemote($formType)
    {
        return false;
    }
}
