<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NewPasswordController extends Controller
{
    public function forgetPassword(Request $request){

        $request->validate([
            'email' => 'required|email',
        ]);

        $email= $request->input('email');
        if(User::where('email', $email)->doesntExists()){
            return response(['message'=>'user doesn\'t exist!'], status: 404);
        }

        $token = Str::random(10);



        // $status = Password::sendResetLink(
        //     $request->only('email'),
        // );

        // if($status == password::RESET_LINK_SENT){
        //     return[
        //         'status'=> __($status)
        //     ];
        // }
        // else{
        //     return $this->sendError('email error',$status);
        // }

        // throw ValidationException::withMessages([
        //     'email'=> [trans($status)],
        // ]);
    }

}
