<?php

namespace App\Http\Controllers;

use App\Models\RtInfo;
use Illuminate\Http\Request;

class RtInfoController extends Controller
{
    public function info(){
        $info = RtInfo::select('rt_sn','rt_dn','rt_type','pid','grade','name','ip','last_linkdown')->get();
        if($info){
            return response()->json([
                'message'=>'success',
                'data'=>$info
            ],200);
        }
        else{
            return response()->json([
                'message'=>'data not found',
            ],464);
        }
    }
}
