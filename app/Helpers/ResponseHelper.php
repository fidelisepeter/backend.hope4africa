<?php
namespace App\Helpers;

use Illuminate\Http\Response;

class ResponseHelper
{

     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public static function success($message, $data = [], $code = 201, $token = null) : Response
    {
    	$response = [
            'success' => true,
            'message' => $message,
        ];

        if(!empty($token)){
            $response['authorization'] = [
                'type' => 'bearer',
                'token' => $token
            ];
        }

        if(!empty($data)){
            $response['data'] = $data;
        }

        return response($response, $code);
    }

    // public static function token($message, $data = [], $code = 201) : Response
    // {
    // 	$response = [
    //         'success' => true,
    //         'message' => $message,
    //     ];

    //     if(!empty($data)){
    //         $response['data'] = $data;
    //     }

    //     return response($response, $code);
    // }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public static function error($errorMessages, $errors = [], $code = 404) : Response
    {
    	$response = [
            'success' => false,
            'message' => $errorMessages,
        ];

        if(!empty($errors)){
            $response['errors'] = $errors;
        }

        return response($response, $code);
    }
    
}
