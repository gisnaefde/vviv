<?php

namespace App\Http\Controllers;

use App\Models\AlarmHist;
use App\Models\SigEventHist;
use App\Models\SigEventHist2;
use App\Models\SigEventHist3;
use App\Models\SigEventHist4;
use App\Models\SigEventHist5;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AlarmHistController extends Controller
{
    public function sendAlarmData()
    {
        // Mendapatkan data terakhir dari tabel RT_INFO
        $lastData = DB::table('TBL_ALARM_HIST')->orderBy('alarm_hist_idx', 'desc')->take(20)->get();
        // return response()->json($lastData);

        $successfulResponses = 0;
        $totalResponses = 0;

        foreach ($lastData as $item) {
            $response = Http::post('http://192.168.8.161/api/alarm', [
                'id_area' => 2,
                'alarm_hist_idx' => $item->alarm_hist_idx,
                'ne_type' => $item->ne_type,
                'log_time' => $item->log_time,
                'issue_time' => $item->issue_time,
                'alarm_id' => $item->alarm_id,
                'status' => $item->status,
                'rt_sn' => $item->rt_sn,
                'user_confirm' => $item->user_confirm,
                'info' => $item->info        
            ]);

            $totalResponses++;

            if ($response->successful()) {
                $successfulResponses++;
            }
        }
        
        if ($totalResponses == $successfulResponses) {
            return response()->json(['message' => 'Data Alarm berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json(['message' => 'Sebagian data Alarm gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
        }
    }


    public function sendMgmt()
    {
        $dataMT = DB::table('TBL_MGMT_GROUP_TREE')->get();

        foreach ($dataMT as $item) {
            $group_id = $item->group_id;
            $pid = $item->pid;
            $name = $item->name;
            $descr = $item->descr;
        
            $response = Http::post('http://192.168.8.161/api/group', [
                'id_area' => 2,
                'group_id' => $group_id,
                'pid' => $pid,
                'name' => $name,
                'descr' => $descr
            ]);

            if (!$response->successful()) {
                return response()->json(['message' => 'Gagal mengirim MGMT ke API'], 500)->header('Content-Type', 'application/json');
            }
        }
        return response()->json(['message' => 'Data MGMT berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');        
    }

    public function sendRtInfo()
{
    // Mendapatkan data terakhir dari tabel RT_INFO
    $dataInfo = DB::table('TBL_RT_INFO')->take(10)->get();

    $successfulResponses = 0;
    $totalResponses = 0;

    foreach ($dataInfo as $item) {
        $response = Http::post('http://192.168.8.161/api/info', [
            'id_area' => 1,
            'rt_sn' => $item->rt_sn,
            'rt_dn' => $item->rt_dn,
            'rt_type' => $item->rt_type,
            'pid' => $item->pid,
            'grade' => $item->grade,
            'name' => $item->name,
            'descr' => $item->descr,
            'loc_code' => $item->loc_code,
            'ip' => $item->ip,
            'cust_text1' => $item->cust_text1,
            'cust_text2' => $item->cust_text2,
            'cust_text3' => $item->cust_text3,
            'cust_text4' => $item->cust_text4,
            'sw_ver' => $item->sw_ver,
            'service_flag' => $item->service_flag,
            'last_linkdown' => $item->last_linkdown,
            'user_freq_set_idx' => $item->user_freq_set_idx,
            'rf_id' => $item->rf_id,
            'gmt_gap' => $item->gmt_gap,
            'video' => $item->video,
            'delete_flag' => $item->delete_flag
        ]);

        $totalResponses++;

        if ($response->successful()) {
            $successfulResponses++;
        }
    }
    
    if ($totalResponses == $successfulResponses) {
        return response()->json(['message' => 'Data RT INFO berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
    } else {
        return response()->json(['message' => 'Sebagian data RT INFO gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
    }
}


    

}
