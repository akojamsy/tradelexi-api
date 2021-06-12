<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function location(){
        $geoIpInfo = geoip()->getLocation($_SERVER["REMOTE_ADDR"]);
        return $geoIpInfo->toarray();
    }
}
