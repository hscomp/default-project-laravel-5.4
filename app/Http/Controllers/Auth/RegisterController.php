<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Forms\UserRegisterForm;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\Auth\EmailActivationService;
use App\Services\Auth\RegisterService;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     * @internal param UserRegisterForm $userRegisterForm
     */
    public function showRegistrationForm()
    {
        $userRegisterForm = new UserRegisterForm('create');

        return view('auth.register', compact('userRegisterForm'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param UserRegisterRequest $request
     *
     * @param RegisterService $registerService
     * @param EmailActivationService $activationService
     * @return \Illuminate\Http\Response
     */
    public function register(
        UserRegisterRequest $request,
        RegisterService $registerService,
        EmailActivationService $activationService
    ) {
        $user = $registerService->register($request->all());

        if (config('registration.email_activation.user')) {
            $activationService->createActivation($user);
        } else {
            $activationService->activateUserForce($user);
        }

        if (config('registration.instant_login.user') && !config('registration.email_activation.user')) {
            $this->guard()->login($user);
        }

        event(new UserRegistered($user));

        if (config('registration.email_activation.user')) {
            $this->sendAlert(trans('responsemessages.registration.user.registration_success_with_activation_link'));
        } else {
            $this->sendAlert(trans('responsemessages.registration.user.registration_success'));
        }

        if (request()->wantsJson()) {
            return $this->ajaxResponse([], $this->redirectPath());
        } else {
            return redirect($this->redirectPath());
        }
    }

    public function activate($token)
    {
        $activationSuccesful = $this->activationService->activateTeam($token);

        $alert = $activationSuccesful
            ? trans('flash.team-activation-success')
            : trans('flash.team-activation-failed');

        $this->sendAlert($alert);

        return redirect()->route('web.homepage.index');
    }


    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

}
