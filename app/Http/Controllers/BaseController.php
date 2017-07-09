<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    // 返回错误的请求
    protected function errorBadRequest($validator)
    {
        // github like error messages
        // if you don't like this you can use code bellow
        //
        //throw new ValidationHttpException($validator->errors());

        $result = [];
        $messages = $validator->errors()->toArray();

        if ($messages) {
            foreach ($messages as $field => $errors) {
                foreach ($errors as $error) {
                    $result[] = [
                        'field' => $field,
                        'code' => $error,
                    ];
                }
            }
        }

        throw new ValidationHttpException($result);
    }

    protected function validateRequest(Request $request, $rules)
    {
        try {
            $this->validate($request, $rules);
        } catch (ValidationException $exception) {
            $this->errorBadRequest($exception->validator);
        }
    }

    /**
     * 业务错误
     * @param $message
     * @param int $code
     */
    protected function serviceAbort($message, $code = 403)
    {
        abort($code, $message);
    }
}
