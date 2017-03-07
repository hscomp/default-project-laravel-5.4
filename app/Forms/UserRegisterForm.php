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
        return [
            'first_name' => [
                'fieldType'         => 'textField',
                'label'             => trans('words.first_name'),
                'create'            => true,
                'edit'              => false,
                'rules'             => 'required|min:2|max:50|name_characters',
            ],
            'last_name' => [
                'fieldType'         => 'textField',
                'label'             => trans('words.last_name'),
                'create'            => true,
                'edit'              => false,
                'rules'             => 'required|min:2|max:50|name_characters',
            ],
            'email' => [
                'fieldType'         => 'textField',
                'label'             => trans('words.email'),
                'create'            => true,
                'edit'              => false,
                'rules'             => 'required|min:3|max:255|email|unique:users',
            ],
            'password' => [
                'fieldType'         => 'passwordField',
                'label'             => trans('words.password'),
                'create'            => true,
                'edit'              => true,
                'rules'             => 'required|min:5|max:30|confirmed',
            ],
            'password_confirmation' => [
                'fieldType'         => 'passwordField',
                'label'             => trans('words.password_confirmation'),
                'create'            => true,
                'edit'              => true,
            ],
        ];
    }

}
