<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use DB;
class data_fetch extends Controller
{
    protected $signature = 'fetch:option-chain';

    protected $description = 'Fetches live data of Nifty option chain and stores it in a SQL database.';

    function get_data(){
        $symbol = 'NIFTY';
        $url = "https://www.nseindia.com/api/option-chain-indices?symbol=$symbol";

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
        if ($response !== false) {
            $data = json_decode($response, true);

            // Assuming the API response structure matches the expected format

            // Process and store the option chain data
            foreach ($data['records']['data'] as $option) {
                try{
                    $expiryDate = $option['expiryDate'];
                $strikePrice = $option['strikePrice'];
                $symbol = $option['CE']['underlying'] ?? ($option['PE']['underlying'] ?? '');
                try{
                    $optionType = ($option['CE'] !== null) ? 'CE' : 'PE';
                }
                catch(\Exception $e){
                    $optionType = ($option['PE'] !== null) ? 'PE' : 'CE';
                }

                $lastPrice = $option['CE']['lastPrice'] ?? $option['PE']['lastPrice'];
                $change = $option['CE']['change'] ?? $option['PE']['change'];
                $percentChange = $option['CE']['pChange'] ?? $option['PE']['pChange'];

                DB::table('option_chain')->insert([
                    'symbol' => $symbol,
                    'expiry_date' => date('Y-m-d', strtotime($expiryDate)),
                    'option_type' => $optionType,
                    'strike_price' => $strikePrice,
                    'last_price' => $lastPrice,
                    'change' => $change,
                    'percent_change' => $percentChange,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                }
                catch(Exception $e){
                    continue;
                }

            }



        } else {
            $this->error('Failed to fetch option chain data: ' . curl_error($curl));
        }

        curl_close($curl);


    }
}


