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
                'formType'              => 'create|edit',
                'fieldComponent'        => 'textField',
                'fieldType'             => 'text',
                'label'                 => trans('words.first_name'),
                'attributes'            => ['class' => 'form-control custom-class', 'placeholder' => 'Vložte jméno'],
                'fieldRootClasses'      => ['custom-class'],
                'fieldRootAttributes'   => ['jmeno' => 'zavicak'],
                'rules'                 => 'required|min:2|max:50|name_characters',
            ],
            'last_name' => [
                'formType'              => 'create|edit',
                'fieldComponent'        => 'textField',
                'fieldType'             => 'text',
                'label'                 => trans('words.last_name'),
                'rules'                 => 'required|min:2|max:50|name_characters',
            ],
            'email' => [
                'formType'              => 'create',
                'fieldComponent'        => 'textField',
                'fieldType'             => 'text',
                'label'                 => trans('words.email'),
                'rules'                 => 'required|min:3|max:255|email|unique:users',
            ],
            'password' => [
                'formType'              => 'create|edit',
                'fieldComponent'        => 'passwordField',
                'fieldType'             => 'password',
                'label'                 => trans('words.password'),
                'rules'                 => 'required|min:5|max:30|confirmed',
            ],
            'password_confirmation'     => [
                'formType'              => 'create|edit',
                'fieldComponent'        => 'passwordField',
                'fieldType'             => 'password',
                'label'                 => trans('words.password_confirmation'),
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

    public function formClasses()
    {
        return ['form-horizontal'];
    }

    public function formAttributes()
    {
        return ['data-preloader' => trans('words.in_progress...')];
    }

    public function submitButtonText()
    {
        return [
            'create' => trans('words.create_account'),
            'edit' => trans('words.create_account'),
        ];
    }

    public function commonFieldRootClasses()
    {
        return ['col-md-12'];
    }

    public function commonFieldRootAttributes()
    {
        return ['custom_attribute' => 'custom_value'];
    }

    public function dataRemote()
    {
        return false;
    }
}
