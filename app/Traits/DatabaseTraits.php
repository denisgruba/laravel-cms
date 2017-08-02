<?php

namespace App\Traits;

use Carbon\Carbon;

trait DatabaseTraits
{
    public function parseDate($publishDate, $publishTime, $customPublish=false, $publishNow=false){
        $dt = Carbon::now();
        if($publishNow){
            $result = $dt;
        }else if (!$customPublish) {
            $result = null;
        } else if ($publishDate == '' && $publishTime == '') {
            $result = null;
        } else if ($publishDate == '') {
            $publish = $dt->year . '/' . $dt->month . '/' . $dt->day . ' ' . $publishTime;
            $result = Carbon::parse($publish);
        } else if ($publishTime == '') {
            $publish = $publishDate . ' ' . $dt->hour . ':' . $dt->minute . ':' . $dt->second;
            $result = Carbon::parse($publish);

        } else {
            $publish = $publishDate . ' ' . $publishTime;
            $result = Carbon::parse($publish);
        }
        return $result;
    }
}
