<?php
namespace App\Services\Auth;

use App\Helpers\Helper;
use App\Models\User;
use App\Services\BaseService;

class RegisterService extends BaseService
{
    /**
     * Register new user.
     *
     * @param $data
     * @return User
     */
    public function register(Array $data)
    {
        return $this->create($data);
    }

    protected function create(Array $data)
    {
        $user = User::create($data);

        Helper::clock(['User successful created', 'user' => $user]);

        return $user;
    }

}