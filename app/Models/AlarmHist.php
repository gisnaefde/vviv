<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlarmHist extends Model
{
    use HasFactory;
    protected $table = 'TBL_ALARM_HIST';

    // protected $fillable = [
    //     'alarm_hist_idx',
    //     'ne_type',
    //     'log_time',
    //     'issue_time',
    //     'alarm_id',
    //     'status',
    //     'rt_sn',
    //     'user_confirm',
    // ];
}
