<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getToken(): JsonResponse
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://radosnikolic.eu.auth0.com/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"client_id\":\"UbD822u660JUBMCvEbIJYAFJPc5lhJFV\",\"client_secret\":\"T-ceJ4-P4hbCL9JyMQSjVICIA6nuvBuSK5ULhGOyQrepUWpNimCat1Zdcw978AtG\",\"audience\":\"http://localhost:8080\",\"grant_type\":\"client_credentials\"}",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json($err, Response::HTTP_UNAUTHORIZED);
        } else {
            return response()->json(json_decode($response), Response::HTTP_OK);
        }
    }
}
