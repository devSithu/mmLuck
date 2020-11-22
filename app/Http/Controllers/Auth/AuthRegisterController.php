<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Response;
use App\Contracts\Services\AuthServiceInterface;

class AuthRegisterController extends Controller
{
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    //create user account
    public function register(Request $request){
        $userData = $this->getUserRegisterData($request);
        $user =  $this->authService->register($userData);
       
        $response = [
            'status' => 200,
            'message' => "Register Success",
            'data' => [
                'name' => $user['data']['name'],
                'token' => $user['token']
            ]
        ];
        return response($response, 200);
    }

    //user login
    public function login(Request $request){
        $user = $this->authService->getUserData($request->email);
        
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('user_token')->accessToken;

                $response = [
                    'status' => 200,
                    'message' => "Login Success",
                    'data' => [
                        'name' => $user['name'],
                        'token' => $token
                    ]
                ];
                
                return response($response, 200);
            } else {
                $response = [
                    'status' => 422,
                    "message" => "Password do not match!"
                ];
                return response($response, 422);
            }
        } else {
            $response = [
                'status' => 422,
                "message" =>'User does not exist'
            ];
            return response($response, 422);
        }
        
    }

    //request user register data
    private function getUserRegisterData($request){
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_no' => $request->phone_no,
            'township_id' => $request->township_id,
            'village_id' => $request->village_id,
            'state_id' => $request->state_id,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        
        return $userData;
    }

}
