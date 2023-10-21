<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * User update
     *
     * @param  mixed  $request
     * @return <object>
     */
    public function updateUser(Request $request, $user_id)
    {
        try {
            $user = User::find($user_id);
            if (! $user) {
                return $this->sendErrorResponse(__('messages.user_not_found'), [], 404);
            }
            $rules = [
                'email' => ['required', 'email', 'unique:users,email,'.$user_id],
                'name' => ['required', 'string'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors()->toArray(), [], 422);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            if ($user->save()) {
                return $this->sendResponse($user->toArray(), __('messages.user_update_success_messages'), 202);
            }
        } catch (Exception $e) {
            return $this->sendResponse(__('messages.something_went_wrong'), [], 500);
        }
    }
}
