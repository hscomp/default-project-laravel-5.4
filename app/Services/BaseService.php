<?php
namespace App\Services;

class BaseService
{
    protected $errors = [];

    protected function addError($error)
    {
        $this->errors[] = $error;
    }

    protected function getErrors()
    {
        return $this->errors;
    }

    protected function hasErrors()
    {
        return count($this->getErrors()) > 0;
    }
}