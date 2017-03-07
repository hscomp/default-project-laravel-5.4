<?php
namespace App\Repositories\Auth;

use App\Models\UserActivation;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class UserActivationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    public function createActivation(User $user)
    {
        $activation = $user->activation;

        if (!$activation) {
            return $this->createToken($user);
        }

        return $this->regenerateToken($user);
    }

    private function regenerateToken($user)
    {
        $token = $this->getToken();

        UserActivation::byuser($user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    private function createToken(User $user)
    {
        $token = $this->getToken();

        UserActivation::insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    public function getActivationByToken($token)
    {
        return UserActivation::byToken($token)->first();
    }

    public function deleteActivation($token)
    {
        UserActivation::byToken($token)->delete();
    }

}