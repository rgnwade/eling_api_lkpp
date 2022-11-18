<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailsLkpp;
use App\Models\UserLkpp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Gate;
use App\Providers\LkppUserProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function ssoLogin(Request $request)
    {

        $xClientId = DetailsLkpp::where('x-client-id', $request->header('X-Client-ID'))->first();
        $xClientSecret = DetailsLkpp::where('x-client-secret', $request->header('X-Client-Secret'))->first();



    if($xClientId == null || $xClientSecret == null){
        return response()->json(array(
                'code' => 400,
                'data' => null,
                'message' => 'ClientID atau ClientSecret Salah',
                'status' => false
            ), 400);
    }else{


        $j_data = $request->getContent();

        $j_data = json_decode($j_data, true);

        $email = $j_data['payload']['email'];
        $usrname = $j_data['payload']['userName'];


    $userExist = UserLkpp::where('email', $email)
                ->orWhere('username', $usrname )
                ->first();


            //Cek user
            if($userExist){

                $user = UserLkpp::where('email', $email)->first();
                $token = JWTAuth::fromUser($user);

                return response()->json(array(
                    'code' => 200,
                    'data' => [
                        'token' => $token
                    ],
                    'message' => null,
                    'status' => true
                ), 200);
            }else{
            
                $token_register = $j_data['token'];

                $client = new \GuzzleHttp\Client(['headers' => [
                'Authorization' => 'Bearer ' . $token_register,        
                'Accept'        => 'application/json',
                ],
                'http_errors' => false
            ]);
            
                  $get_data1 = $client->requestAsync('POST','https://dev-tokodaring-api.lkpp.go.id/uma/sso/auth')->then( function ($response) {
                                    return json_decode($response->getBody()->getContents());
                                  }
                                  );
            
                    $response_get_token = $get_data1->wait();

                    // dd($response_get_token);
    
                    if ($response_get_token->code===200){

                        $register = UserLkpp::create(array(
                                        'last_name'         => $j_data['payload']['userName'],
                                        'first_name'        => $j_data['payload']['realName'],
                                        'phone'             => $j_data['payload']['phone'],
                                        'role'              => $j_data['payload']['role'],
                                        'lpseId'            => $j_data['payload']['lpseId'],
                                        'isLatihan'         => $j_data['payload']['isLatihan'],
                                        'email'             => $j_data['payload']['email'],
                                        'time'              => $j_data['payload']['time'],
                                        'idInstansi'        => $j_data['payload']['idInstansi'],
                                        'namaInstansi'      => $j_data['payload']['namaInstansi'],
                                        'idSatker'          => $j_data['payload']['idSatker'],
                                        'namaSatker'        => $j_data['payload']['namaSatker'],
                                        'token_lkpp'        => $j_data['token'],
                                        'password'          => "0",
                                        'uuid'              => "false"
                                    ));

                                    if($register){
                                                 return response()->json(array(
                                                        'code' => 200,
                                                        'data' => $register,
                                                        'message' => "Token is valid",
                                                        'status' => true
                                                    ), 200);
                                                }else{
                                                    return response()->json(array(
                                                            'code' => 400,
                                                            'message' => 'Token is invalid',
                                                            'status' => false
                                                        ), 200); 
                                    }
                    }else{
                        return response()->json(array(
                            'code' => 400,
                            'message' => 'Token is invalid',
                            'status' => false
                        ), 200); 
                    }
            }
        }



     }
}

?>