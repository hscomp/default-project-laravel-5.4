<?php
namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function fullName()
    {
        return $this->entity->first_name . ' ' . $this->entity->last_name;
    }

}