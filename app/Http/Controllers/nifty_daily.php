<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class nifty_daily extends Controller
{
    function nifty_data(){

        $url = "https://www.nseindia.com/api/equity-stockIndices?index=NIFTY%2050";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            // CURLOPT_HTTPHEADER => [
            //     'Accept: application/json',
            //     'User-Agent: Mozilla/5.0',
            // ],
        ]);

        $response = curl_exec($curl);
        $data = json_decode($response, true);

        $open = $data['data'][0]['open'];
        $close = $data['data'][0]['lastPrice'];
        $low = $data['data'][0]['dayLow'];
        $high = $data['data'][0]['dayHigh'];
        $timestamp = Carbon::createFromFormat('d-M-Y H:i:s', $data['timestamp'])->toDateTimeString();

        $existingRecord = DB::selectOne('SELECT * FROM nifty50_data WHERE timestamp = ?', [$timestamp]);

        // Insert the record if it doesn't exist
        if (!$existingRecord) {
            DB::insert('INSERT INTO nifty50_data (open, close, low, high, timestamp) VALUES (?, ?, ?, ?, ?)', [$open, $close, $low, $high, $timestamp]);
}
    }
}
