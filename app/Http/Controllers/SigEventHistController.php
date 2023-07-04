<?php

namespace App\Http\Controllers;

use App\Models\SigEventHist;
use Illuminate\Http\Request;

class SigEventHistController extends Controller
{
    public function sigeventhist(){
        $sigeventhist = SigEventHist::select('sig_hist_idx','rt_sn','log_time','issue_time','clear_time','freq','bandwidth','sig_pwr')->get();
        $maxfreq = SigEventHist::max('freq');
        $maxbandwidth = SigEventHist::max('bandwidth');
        $maxsigpwr = SigEventHist::max('sig_pwr');

        $data = [
            'max-freq' => $maxfreq,
            'max-bandwidth' => $maxbandwidth,
            'max-power' => $maxsigpwr,
            'sigevent-history' => $sigeventhist
        ];

        if($data){
            return response()->json([
                'message'=>'success',
                'data'=>$data
            ],200);
        }
        else{
            return response()->json([
                'message'=>'data not found',
            ],464);
        }
    }
}
