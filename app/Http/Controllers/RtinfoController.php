<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AlarmHistController extends Controller
{
    public function sendRtInfo()
    {
        // Mendapatkan data terakhir dari tabel RT_INFO
        $dataInfo = DB::table('TBL_RT_INFO')->get();

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

        if ($totalResponses == 0) {
            return response()->json(['message' => 'Tidak ada data di tabel "RT_INFO"'], 404);
        } else if ($totalResponses == $successfulResponses) {
            return response()->json(['message' => 'Data RT INFO berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json(['message' => 'Sebagian data RT INFO gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
        }
    }


    

}
