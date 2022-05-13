<?php

namespace App\Http\Controllers\API;

use App\Models\Signal;
use Illuminate\Http\Request;
use App\Http\Resources\signal as SignalResource;
use App\Http\Controllers\API\BaseController as BaseController ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SignalController extends BaseController

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSignal()
    {
        //Signal::all();
        $user=Auth::user();
        $id= $user->id;
        $Signals = Signal::where('user_id', $id)->get();

        return $this->sendResponse(SignalResource::collection($Signals), 'ALL signals retrieved');

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all() , [
            'type'=> 'required|string',
            'classification'=> 'required',
            'prop_of_seiz'=> 'required',
            'prop_of_non_seiz'=> 'required',
            // 'patient_id'=> 'required',

        ]);
        if($validator->fails()){
            return $this->sendError('Please Validate Error', $validator->errors());
        }

        $input = $request->all();
        $user=Auth::user();
        $input['patient_id']= $user->id;
        $signal = Signal::create($input);

        return $this->sendResponse(new SignalResource($signal),'Signal created successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Signal  $signal
     * @return \Illuminate\Http\Response
     */
    public function show(Signal $signal)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Signal  $signal
     * @return \Illuminate\Http\Response
     */
    public function edit(Signal $signal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Signal  $signal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signal $signal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signal  $signal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signal $signal)
    {
        //
        $signal->delete();
        $signal->save();
        return $this->sendResponse(SignalResource::collection($signal), 'deleted successfully');

    }

}
