<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController ;
use App\Http\Resources\symptom_user as symptom_userResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\symptom_user;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class symptom_userController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getsymptom()
    {
        //
        $user=Auth::user();
        $id= $user->id;
        $symptom = symptom_user::where('patient_id', $id)->get();
        // return[ $connection];
        // $doctors = Doctor::where('id', $connection->doctor_id)->get();
        return $this->sendResponse(symptom_userResource::collection($symptom), 'ALL connection retrieved');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'symptom_id'=> 'required'

        ]);
        if($validator->fails()){
            return $this->sendError('Please Validate Error', $validator->errors());
        }

        $input = $request->all();
        $user=Auth::user();
        $input['user_id']= $user->id;
        $symptom = symptom_user::create($input);

        return $this->sendResponse(new symptom_userResource($symptom),'symptoms created successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=Auth::user();
        $users_id= $user->id;
        $input = $request->all();
        $validator = Validator::make($input , [
            'symptom_id'=> 'required',

        ]);
        if($validator->fails()){
            return $this->sendError('Please Validate Error', $validator->errors());
        }
     DB::update('update symptom_user set symptom_id = ?, user_id = ?
     where id = ?', [$request->symptom_id, $users_id , $id]);

     return $this->sendResponse([],'data is updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
