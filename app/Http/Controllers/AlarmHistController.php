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

    public function sendAlarmData()
    {
        // Mendapatkan data terakhir dari tabel "alarm"
        $lastData = DB::table('TBL_ALARM_HIST')->orderBy('alarm_hist_idx', 'desc')->first();
        // return response()->json([
        //     'message' => 'Data  berhasil dikirim ke API',
        //     'data'=> $lastData
        // ], 200);
        if ($lastData) {
            // Mengirim data terakhir ke API dengan server 
            $response = Http::post('http://192.168.8.136/api/alarm', [
                'id_area' => 1,
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

    public function sendMgmt()
    {
        $dataMT = DB::table('TBL_MGMT_GROUP_TREE')->get();

        foreach ($dataMT as $item) {
            $group_id = $item->group_id;
            $pid = $item->pid;
            $name = $item->name;
            $descr = $item->descr;
        
            $response = Http::post('http://192.168.8.136/api/group', [
                'id_area' => 1,
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
        $dataInfo = DB::table('TBL_RT_INFO')->get();

        foreach ($dataInfo as $item ){
            $rt_sn = $item->rt_sn;
            $rt_dn = $item->rt_dn;
            $rt_type = $item->rt_type;
            $pid = $item->pid;
            $grade = $item->grade;
            $name = $item->name;
            $descr = $item->descr;
            $loc_code = $item->loc_code;
            $ip = $item->ip;
            $cust_text1 = $item->cust_text1;
            $cust_text2 = $item->cust_text2;
            $cust_text3 = $item->cust_text3;
            $cust_text4 = $item->cust_text4;
            $sw_ver = $item->sw_ver;
            $service_flag = $item->service_flag;
            $last_linkdown = $item->last_linkdown;
            $user_freq_set_idx = $item->user_freq_set_idx;
            $rf_id = $item->rf_id;
            $gmt_gap = $item->gmt_gap;
            $video = $item->video;
            $delete_flag = $item->delete_flag;
            // Mengirim data terakhir ke API dengan server 
            $response = Http::post('http://192.168.8.136/api/info', [
                'id_area' => 1,
                'rt_sn' => $rt_sn,
                'rt_dn' => $rt_dn,
                'rt_type' => $rt_type,
                'pid' => $pid,
                'grade' => $grade,
                'name' => $name,
                'descr' => $descr,
                'loc_code' => $loc_code,
                'ip' => $ip,
                'cust_text1' => $cust_text1,
                'cust_text2' => $cust_text2,
                'cust_text3' => $cust_text3,
                'cust_text4' => $cust_text4,
                'sw_ver' => $sw_ver,
                'service_flag' => $service_flag,
                'last_linkdown' => $last_linkdown,
                'user_freq_set_idx' => $user_freq_set_idx,
                'rf_id' => $rf_id,
                'gmt_gap' => $gmt_gap,
                'video' => $video,
                'delete_flag' => $delete_flag
            ]);

            if (!$response->successful()) {
                return response()->json(['message' => 'Gagal mengirim data RT INFO ke API'], 500)->header('Content-Type', 'application/json');
            }
        }
        
        return response()->json(['message' => 'Data RT INFO berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');        
    }

    public function sendEventHist()
    {
        $data = DB::table('TBL_SIGEVENT_HIST_RT0001')->first();
        // return response()->json([
        //     'message' => 'Data  berhasil dikirim ke API',
        //     'data'=> $data
        // ], 200);
        if ($data) {
            // Mengirim data ke API dengan server 
            $response = Http::post('http://192.168.8.136/api/sigevent-hist', [
                'id_area' => 1,
                'sig_hist_idx' => $data->sig_hist_idx,
                'rt_sn' => $data->rt_sn,
                'detect_id' => $data->detect_id,
                'log_time' => $data->log_time,
                'issue_time' => $data->issue_time,
                'cleared' => $data->cleared,
                'clear_time' => $data->clear_time,
                'detect_type' => $data->detect_type,
                'detect_type_dupl' => $data->detect_type_dupl,
                'freq_type' => $data->freq_type,
                'spread_type' => $data->spread_type,
                'freq' => $data->freq,
                'bandwidth' => $data->bandwidth,
                'sig_pwr' => $data->sig_pwr,
                'freq_assign_code' => $data->freq_assign_code,
                'modulation_type' => $data->modulation_type,
                'presumed_type' => $data->presumed_type,
                'file_path' => $data->file_path,
                'audio_stored' => $data->audio_stored,
                'audio_file_name' => $data->audio_file_name,
                'video_stored' => $data->video_stored,
                'video_file_name' => $data->video_file_name,
                'spectrum_stored' => $data->spectrum_stored,
                'spectrum_file_name' => $data->spectrum_file_name,
                'signal_stored' => $data->signal_stored,
                'signal_file_name' => $data->signal_file_name,
                'user_confirm' => $data->user_confirm,
                'confirm_time' => $data->confirm_time,
                'data_exist' => $data->data_exist,
                'sig_dupl_hist_idx' => $data->sig_dupl_hist_idx,
            ]);


            if ($response->successful()) {
                return response()->json(['message' => 'Data Event berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
            } else {
                return response()->json(['message' => 'Data Event gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
            }
        } else {
            return response()->json(['message' => 'Tidak ada data di tabel'], 404);
        }
    }

}
