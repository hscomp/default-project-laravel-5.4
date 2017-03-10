<?php
namespace App\Services\Auth;

use App\Models\User;
use App\Notifications\Auth\SendUserRegistrationActivationLink;
use App\Notifications\Auth\SendUserSuccessfulActivationConfirmation;
use App\Repositories\Auth\UserActivationRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use DB;

class EmailActivationService extends BaseService
{
    protected $activationRepository;

    protected $resendAfter = 24;

    public function __construct(UserActivationRepository $activationRepository)
    {
        $this->activationRepository = $activationRepository;
    }

    public function createActivation(User $user)
    {
        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepository->createActivation($user);

        $this->sendActivationMail($user, $token);
    }

    protected function sendActivationMail(User $user, $token)
    {
        $activationLink = route('auth.activate', $token);

        $user->notify(new SendUserRegistrationActivationLink($activationLink));
    }

    public function sendActivationConfirmationMail(User $user)
    {
        $loginLink = route('auth.login');

        $user->notify(new SendUserSuccessfulActivationConfirmation($loginLink));
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepository->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        DB::beginTransaction();

        $user = User::findOrFail($activation->user_id);

        $user->activated = true;

        $user->save();

        $this->activationRepository->deleteActivation($token);

        DB::commit();

        $this->sendActivationConfirmationMail($user);

        return $user;
    }

    public function activateUserForce(User $user)
    {
        $user->activated_at = Carbon::now();

        $user->save();
    }

    private function shouldSend(User $user)
    {
        $activation = $user->activation;

        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}