<?php

namespace App\Forms\Contracts;

interface ModelFormInterface
{
    public function fields();

    public function getFields($formType);

    public function getRules($formType);

}