<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\connection;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Resources\Connection as ConectionResource;
use App\Http\Controllers\API\BaseController as BaseController ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ConnectionController extends BaseController

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConnection()
    {
        //
        $user=Auth::user();
        $id= $user->id;
        $connection = connection::where('user_id', $id)->get();
        // return[ $connection];
        // $doctors = Doctor::where('id', $connection->doctor_id)->get();
        return $this->sendResponse(ConectionResource::collection($connection), 'ALL connection retrieved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(connection $connection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(connection $connection)
    {
        //
        $connection->delete();
        return $this->sendResponse(ConectionResource::collection($connection), 'deleted successfully');

    }
}
