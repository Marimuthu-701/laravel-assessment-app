<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param  string  $message
     * @param  mixed  $data
     * @return (array)
     */
    protected function makeResponse($message, $data = []): array
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];
    }

    /**
     * @param  string  $message
     * @param  array  $data
     */
    public static function makeError($message, $data = []): array
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }

    /**
     * @param  array  $result
     * @param  string  $message
     * @param  int  $code
     * @return json
     */
    public function sendResponse($result, $message, $code = 200): JsonResponse
    {
        return Response::json($this->makeResponse($message, $result), $code);
    }

    /**
     * @param  string  $message
     * @param  array  $result
     * @param  int  $code
     * @return json
     */
    public function sendErrorResponse($message, $result = [], $code = 200): JsonResponse
    {
        $messages = [];
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                $messages[] = is_array($value) ? implode(', ', $value) : $value;
            }

            $message = implode(', ', $messages);
        }

        return Response::json($this->makeError($message, $result), $code);
    }
}
