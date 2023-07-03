<?php

namespace App\Http\Controllers;

use App\Models\AlarmHist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;

class AlarmHistController extends Controller
{

    public function alarm_hist(){
        $alarmhist = AlarmHist::select('alarm_hist_idx','ne_type','log_time','issue_time','alarm_id','status','rt_sn')->get();

        return response()->json($alarmhist);
    }


    public function alarm_stat(){

        $today = Carbon::today();

        $alarmstat = AlarmHist::select('alarm_hist_idx','status')->get();
        $countH = AlarmHist::where('status', 'h')->count();
        $countC = AlarmHist::where('status', 'c')->count();
        $statusHToday =  AlarmHist::where('status', 'h')->whereDate('issue_time', $today)->count();
        $statusCToday =  AlarmHist::where('status', 'c')->whereDate('issue_time', $today)->count();

        $data = [
            'count_h' => $countH,
            'count_c' => $countC,
            'count_h_today' => $statusHToday,
            'count_c_today' => $statusCToday,
            'alarm_stat' => $alarmstat
        ];

    return response()->json($data);
    }
}
