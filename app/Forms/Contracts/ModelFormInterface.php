<?php

namespace App\Forms\Contracts;

interface ModelFormInterface
{
    public function getFields();

    public function getRules();

}