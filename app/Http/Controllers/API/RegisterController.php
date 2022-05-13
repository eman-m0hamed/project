<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Symptom;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{


   public function register(Request $request){

    $validator = Validator::make($request->all() , [
        'name'=> 'required|string',
        'email'=> 'required|email',
        'password'=> 'required|string|min:4',
        'city'=> 'required|string',
        'country'=> 'required|string',
        'gender'=> 'required',
        'national_id'=> 'required',
        'phone'=>'required',



    ]);
    if($validator->fails()){
        return $this->sendError('Please Validate Error', $validator->errors());
    }


    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    // $user = User::create([
    //     'name'=> $input['name'],
    //     'email'=> $input['email'],
    //     'password'=> $input['password'],
    //     'city'=> $input['city'],
    //     'country'=> $input['country'],
    //     'gender'=> $input['gender'],
    //     'national_id'=>$input['national_id'],
    //     'phone'=>$input['phone'],
    //     // 'bith_day'=>$input['bith_day'],
    // ]);
    // $user->Symptom()->attach($request->symptoms);
    $user = User::create($input);
    $success['token']= $user->createToken('hdfgj')->accessToken;
    $success['name'] = $user->name;
    return [$success,'User registered successfully'];
    return $this->sendResponse($success,'User registered successfully');

   }


   public function login(Request $request){

    $request->validate([
            'email' =>  'required',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user =$request->user();
        $tokenResult = $user->createToken('personal access token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addweeks(1);
        $token->save();

        return response()->json(['data'=>[
            'user'=>Auth::user(),
            'access_token' =>  $tokenResult->accessToken,
            'token_type'=> 'Bearer',
            'expires_at' => Carbon::parse( $tokenResult->token->expires_at)->toDateString()
        ]]);
    }

}



