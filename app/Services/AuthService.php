<?php

namespace App\Services;

use App\Contracts\Dao\AuthDaoInterface;
use App\Contracts\Services\AuthServiceInterface;


class AuthService implements AuthServiceInterface
{
    private $authDao;

    public function __construct(AuthDaoInterface $authDao)
    {
        $this->authDao = $authDao;
    }

    //create user account
    public function register($userInfo){
        $userDataArray = array();
        $newUser = $this->authDao->createUser($userInfo);

        $userDataArray['data'] = $newUser;
        $userDataArray['token'] = $newUser->createToken('user_token')->accessToken;
        return $userDataArray;
    }

    //get user data
    public function getUserData($email){
        return $this->authDao->getUserData($email);
    }
}