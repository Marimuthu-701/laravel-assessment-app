<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /**
     * User login
     *
     * @param  mixed  $request
     * @return <object>
     */
    public function login(Request $request): object
    {
        try {
            $rules = [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors()->toArray(), [], 422);
            }

            if (! Auth::attempt($request->only('email', 'password'))) {
                return $this->sendErrorResponse(__('messages.invalid_login_details'), [], 401);
            }

            $user = User::where('email', $request->email)->first();
            $data = $user->toApi();
            $data['token'] = $user->accessToken($request->email);

            return $this->sendResponse($data, __('messages.login_success_message'), 200);
        } catch (Exception $e) {
            return $this->sendErrorResponse(__('messages.something_went_wrong'), [], 500);
        }
    }

    /**
     * User Registration
     *
     * @param  mixed  $request
     * @return <object>
     */
    public function register(Request $request): object
    {
        try {
            $rules = [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', 'min:6'],
                'password_confirmation' => ['min:6'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors()->toArray(),[], 422);
            }
            $data = $request->except('password_confirmation');
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $data = $user->toApi();
            $data['token'] = $user->accessToken($request->email);

            return $this->sendResponse($data, __('messages.registration_success'), 201);
        } catch (Exception $e) {
            return $this->sendErrorResponse(__('messages.something_went_wrong'), [], 500);
        }
    }
}
