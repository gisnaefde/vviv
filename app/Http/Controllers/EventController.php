<?php

namespace App\Http\Controllers;
use App\Models\SigEventHist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class EventController extends Controller
{
    public function sendEventHist()
    {
        // Mendapatkan data terakhir dari tabel TBL_SIGEVENT_HIST_RT0005
        $data = DB::table('TBL_SIGEVENT_HIST_RT0001')->orderBy('sig_hist_idx', 'desc')->take(20)->get();
    
        $successfulResponses = 0;
        $totalResponses = 0;
    
        foreach ($data as $item) {
            $response = Http::post('http://192.168.8.161/api/sigevent-hist', [
                'id_area' => 2,
                'sig_hist_idx' => $item->sig_hist_idx,
                'rt_sn' => $item->rt_sn,
                'detect_id' => $item->detect_id,
                'log_time' => $item->log_time,
                'issue_time' => $item->issue_time,
                'cleared' => $item->cleared,
                'clear_time' => $item->clear_time,
                'detect_type' => $item->detect_type,
                'detect_type_dupl' => $item->detect_type_dupl,
                'freq_type' => $item->freq_type,
                'spread_type' => $item->spread_type,
                'freq' => $item->freq,
                'bandwidth' => $item->bandwidth,
                'sig_pwr' => $item->sig_pwr,
                'freq_assign_code' => $item->freq_assign_code,
                'modulation_type' => $item->modulation_type,
                'presumed_type' => $item->presumed_type,
                'file_path' => $item->file_path,
                'audio_stored' => $item->audio_stored,
                'audio_file_name' => $item->audio_file_name,
                'video_stored' => $item->video_stored,
                'video_file_name' => $item->video_file_name,
                'spectrum_stored' => $item->spectrum_stored,
                'spectrum_file_name' => $item->spectrum_file_name,
                'signal_stored' => $item->signal_stored,
                'signal_file_name' => $item->signal_file_name,
                'user_confirm' => $item->user_confirm,
                'confirm_time' => $item->confirm_time,
                'data_exist' => $item->data_exist,
                'sig_dupl_hist_idx' => $item->sig_dupl_hist_idx,
            ]);
    
            $totalResponses++;
    
            if ($response->successful()) {
                $successfulResponses++;
            }
        }
    
        if ($totalResponses == 0) {
            return response()->json(['message' => 'Tidak ada data di tabel'], 404);
        } else if ($totalResponses == $successfulResponses) {
            return response()->json(['message' => 'Data Event berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json(['message' => 'Sebagian data Event gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
        }
    }
    
    
    public function sendEventHist2()
    {
        // Mendapatkan data terakhir dari tabel TBL_SIGEVENT_HIST_RT0005
        $data = DB::table('TBL_SIGEVENT_HIST_RT0002')->orderBy('sig_hist_idx', 'desc')->take(20)->get();
    
        $successfulResponses = 0;
        $totalResponses = 0;
    
        foreach ($data as $item) {
            $response = Http::post('http://192.168.8.161/api/sigevent-hist', [
                'id_area' => 2,
                'sig_hist_idx' => $item->sig_hist_idx,
                'rt_sn' => $item->rt_sn,
                'detect_id' => $item->detect_id,
                'log_time' => $item->log_time,
                'issue_time' => $item->issue_time,
                'cleared' => $item->cleared,
                'clear_time' => $item->clear_time,
                'detect_type' => $item->detect_type,
                'detect_type_dupl' => $item->detect_type_dupl,
                'freq_type' => $item->freq_type,
                'spread_type' => $item->spread_type,
                'freq' => $item->freq,
                'bandwidth' => $item->bandwidth,
                'sig_pwr' => $item->sig_pwr,
                'freq_assign_code' => $item->freq_assign_code,
                'modulation_type' => $item->modulation_type,
                'presumed_type' => $item->presumed_type,
                'file_path' => $item->file_path,
                'audio_stored' => $item->audio_stored,
                'audio_file_name' => $item->audio_file_name,
                'video_stored' => $item->video_stored,
                'video_file_name' => $item->video_file_name,
                'spectrum_stored' => $item->spectrum_stored,
                'spectrum_file_name' => $item->spectrum_file_name,
                'signal_stored' => $item->signal_stored,
                'signal_file_name' => $item->signal_file_name,
                'user_confirm' => $item->user_confirm,
                'confirm_time' => $item->confirm_time,
                'data_exist' => $item->data_exist,
                'sig_dupl_hist_idx' => $item->sig_dupl_hist_idx,
            ]);
    
            $totalResponses++;
    
            if ($response->successful()) {
                $successfulResponses++;
            }
        }
    
        if ($totalResponses == 0) {
            return response()->json(['message' => 'Tidak ada data di tabel'], 404);
        } else if ($totalResponses == $successfulResponses) {
            return response()->json(['message' => 'Data Event berhasil dikirim ke API'], 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json(['message' => 'Sebagian data Event gagal dikirim ke API'], 500)->header('Content-Type', 'application/json');
        }
    }
    
}



