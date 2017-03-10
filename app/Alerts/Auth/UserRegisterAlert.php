<?php
namespace App\Alerts\Auth;

use App\Alerts\BaseAlert;

class UserRegisterAlert extends BaseAlert
{
    protected $ajaxRedirect = false;

    public function userSuccessfullyRegistered()
    {
        if (config('registration.email_activation.user')) {
            $this->sendAlert(trans('responsemessages.registration.user.registration_success_with_activation_link'));
        } else {
            $this->sendAlert(trans('responsemessages.registration.user.registration_success'));
        }
    }
}