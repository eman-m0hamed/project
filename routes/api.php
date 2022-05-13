<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\API\ConnectionController;
use App\Http\Controllers\API\SignalController;
use App\Http\Controllers\API\symptomController;
use App\Http\Controllers\API\symptom_userController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[RegisterController::class,'register']);
Route::post('login',[RegisterController::class,'login']);


Route::middleware('auth:api')->group( function(){
    Route::resource('users', 'PatientController');

    Route::get('profile',[PatientController::class,'index']);
    Route::get('profileShow',[PatientController::class,'show']);
    Route::put('profileUpdate',[PatientController::class,'update']);

});


Route::middleware('auth:api')->group( function(){
    Route::resource('signals', 'SignalController');
    Route::get('signalHistory',[SignalController::class,'getSignal']);
    Route::post('storeSignal',[SignalController::class,'store']);
    // Route::delete('deleteSignal/{id}',[SignalController::class,'destroy']);

});

Route::middleware('auth:api')->group( function(){
    Route::resource('symptom_user', 'symptom_userController');

    Route::get('symptomData',[symptom_userController::class,'getsymptom']);
    Route::post('symptomStore',[symptom_userController::class,'store']);
    Route::put('symptomUpdate',[symptom_userController::class,'update']);
    // Route::delete('symptomDelete',[symptomController::class,'destroy']);

});

Route::middleware('auth:api')->group( function(){
    Route::resource('connections', 'ConnectionController');
    Route::get('connectionData',[ConnectionController::class,'getConnection']);
    Route::delete('connectionDelete',[ConnectionController::class,'destroy']);


});


// Route::group([
//     'prefix' => 'auth'],
//     function(){
//         Route::post('login','RegisterController@login');
//         Route::post('register','RegisterController@register');
//     });



Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:4|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();
            $user->tokens()->delete();

            event(new PasswordReset($user));
        }
    );

    if( $status === Password::PASSWORD_RESET){
        return response([
            'message'=>'password reset successfully',
        ]);
    }
    else{
        return response(['message'=>__($status)], 500);

    }
})->middleware('auth:api')->name('password.update');
