<?php

namespace App\Http\Controllers;

use App\Models\AlarmHist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;
use Illuminate\Support\Facades\Http;

class AlarmHistController extends Controller
{

    public function alarm_hist(){
        $alarmhist = AlarmHist::select('alarm_hist_idx','ne_type','log_time','issue_time','alarm_id','status','rt_sn')->get();
        if($alarmhist){
            return response()->json([
                'message'=>'success',
                'data'=>$alarmhist
            ],200);
        }
        else{
            return response()->json([
                'message'=>'data not found',
            ],464);
        }

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

    public function sendAlarmData()
    {
        // Mendapatkan data terakhir dari tabel "alarm"
        $lastData = DB::table('TBL_ALARM_HIST')->orderBy('alarm_hist_idx', 'desc')->first();
        // return response()->json([
        //     'message'=>'berhasil',
        //     'data'=> $lastData
        // ]);
        if ($lastData) {
            // Mengirim data terakhir ke API dengan server 
            $response = Http::post('http://192.168.8.136/api/alarm', [
                'alarm_hist_idx' => $lastData->alarm_hist_idx,
                'ne_type' => $lastData->ne_type,
                'log_time' => $lastData->log_time,
                'issue_time' => $lastData->issue_time,
                'alarm_id' => $lastData->alarm_id,
                'status' => $lastData->status,
                'rt_sn' => $lastData->rt_sn,
                'user_confirm' => $lastData->user_confirm,
                'info' => $lastData->info
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Data terakhir berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
            } else {
                return response()->json(['message' => 'Data terakhir gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
            }
        } else {
            return response()->json(['message' => 'Tidak ada data di tabel "alarm"'], 404);
        }
    }
}
