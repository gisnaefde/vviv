<?php

namespace App\Http\Controllers;

use App\Models\MgmtGroup;
use Illuminate\Http\Request;

class MgmtGroupController extends Controller
{
    public function mgmt(){
        $group = MgmtGroup::all();

        if($group){
            return response()->json([
                'message'=>'Success',
                'data'=>$group
            ],200);
        }else{
            return response()->json([
                'message'=>'data not found'
            ],464);
        }
    }
}
