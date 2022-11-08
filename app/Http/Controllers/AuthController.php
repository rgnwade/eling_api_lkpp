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
                'message' => 'ClientID & ClientSecret Salah',
                'status' => false
            ), 400);
    }else{


        $j_data = $request->getContent();

        $j_data = json_decode($j_data, true);

        $eml = $j_data['payload']['email'];


    $userExist = UserLkpp::where('email', $eml)
        ->first();


if($userExist == null){
        $register = UserLkpp::create(array(
            'last_name'          => $j_data['payload']['userName'],
            'first_name'          => $j_data['payload']['realName'],
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
    }


    $user = UserLkpp::where('email', $eml)->first();

    $token = JWTAuth::fromUser($user);
  if($token){
         return response()->json(array(
                'code' => 200,
                'data' => [
                    'token' => $token
                ],
                'message' => null,
                'status' => true
            ), 200);
        }else{
            return response()->json(array(
                    'code' => 200,
                    'data' => null,
                    'message' => 'The requested object was not found.',
                    'status' => false
                ), 200);

        }

    }   
}


   



}
?>