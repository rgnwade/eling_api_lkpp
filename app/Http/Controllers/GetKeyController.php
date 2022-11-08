<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailsLkpp;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Gate;



class GetKeyController extends Controller
{

    public function GetDetailsKey(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
        ]);

        $xClientId = Str::random(8);
        $xClientSecret = Str::random(18);
     

    $registerDetails = DetailsLkpp::create(array(
            'username'          => $request->input('username'),
            'x-client-id'       => $xClientId,
            'x-client-secret'   => $xClientSecret,
            'x-vertical-type'   => $request->input('x-vertical-type'),
        ));

    if($registerDetails){  
        return response()->json(array(
            'status' => 200,
            'data' => $registerDetails,
            'message' => 'Sukses membuat details Key'
        ), 200);  
    }else{
     return response()->json(array(
                'status' => 400,
                'message' => 'Terjadi Kesalahan'
            ), 404);
      }
    }

    

}
?>