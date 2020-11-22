<?php

namespace App\Dao;

use App\Models\User;
use App\Contracts\Dao\AuthDaoInterface;

class AuthDao implements AuthDaoInterface
{

    // create user account
    public function createUser($userData){
        return User::create($userData);
    }

    //get user data
    public function getUserData($email){
        return User::where('email', $email)->first();
    }
}