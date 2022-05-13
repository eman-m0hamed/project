<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Patient as PatientResource;
use App\Http\Controllers\API\BaseController as BaseController ;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class PatientController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $patients = User::all();
        // $patients['password'] = decrypt($patients['password']);

        $user=Auth::user();
        $id= $user->id;
        $patient = User::where('id', $id)->get();

        return $this->sendResponse(PatientResource::collection($patient), 'ALL Patient data sent');

    }


    function getPatient($id){
        $patients = User::all();
        // $patients['password'] = decrypt($patients['password']);

        foreach($patients as $patient){
            if($patient['id']==$id){
               return $patient;
            }
        }
        return null;
    }

    function show(){
        $user=Auth::user();
        $id= $user->id;
        $patientData= $this->getPatient($id);
        if($patientData == null){
            return [
                'success' => false,
                'message' => "No such user with id = $id"
            ];
        }

        return[
            'success' => true,
            'data'=> $patientData,
        ];

    }


    public function update(Request $request, User $patient)
    {

        $user=Auth::user();
        $id= $user->id;
        $input = $request->all();
        $validator = Validator::make($input , [
            'name'=> 'required|string',
            'email'=> 'required|email',
            'password'=> 'required|string|min:4',
            'city'=> 'required',
            'country'=> 'required',
            'gender'=> 'required',
            'national_id'=> 'required',
            'phone'=> 'required',

        ]);
        if($validator->fails()){
            return $this->sendError('Please Validate Error', $validator->errors());
        }
        // $patient->email= $input['email'];
        // $patient[$id]->update($request->all());
        $password= Hash::make($request->password);
     DB::update('update users set name = ?, email=?, password=?, gender=?, birth_day=?, city=?, country=?, phone=?, national_id=?
     where id = ?', [$request->name, $request->email, $password, $request->gender, $request->birth_day, $request->city, $request->country, $request->phone, $request->national_id, $id]);

     return $this->sendResponse([],'data is updated');

    }


}
