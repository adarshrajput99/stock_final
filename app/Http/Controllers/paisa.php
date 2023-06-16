<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class paisa extends Controller
{
    private $token='';
   function call_5paisa($TOTP){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post('https://Openapi.5paisa.com/VendorsAPI/Service1.svc/TOTPLogin', [
            'head' => [
                'Key' => 'ge6qMCyn7io76MtOG50x2WMZpfoceK7u'
            ],
            'body' => [
                'Email_ID' => '50822588',
                'TOTP' => $TOTP,
                'PIN' => '001265'
            ]
        ]);
        $data = json_decode($response);

        // Access the values
        $clientCode = $data->body->ClientCode;
        $message = $data->body->Message;
        $redirectURL = $data->body->RedirectURL;
        $requestToken = $data->body->RequestToken;
        $status = $data->body->Status;
        $userKey = $data->body->Userkey;

        echo "Client Code: $clientCode\n";
        echo "Message: $message\n";
        echo "Redirect URL: $redirectURL\n";
        echo "Request Token: $requestToken\n";
        echo "Status: $status\n";
        echo "User Key: $userKey\n";

        return  $requestToken;
        $filePath = public_path('request_token.txt'); // Set the file path

        // Check if the file exists
        if (file_exists($filePath)) {
            // Clear the existing file contents
            file_put_contents($filePath, '');
        }

        // Create a new file or open the existing file in write mode
        $file = fopen($filePath, 'w');

        // Write the request token into the file
        fwrite($file, $requestToken);

        // Close the file
        fclose($file);

        // Output a success message
        echo "Request token has been written to the file.";

    }

    function testing($token){
        $filePath = public_path('request_token.txt'); // Set the file path

        // Read the file contents into a variable
        $contents = file_get_contents($filePath);

        // Output the file contents

        $response = Http::withHeaders([
            'x-clientcode' => '50822588',
            'x-auth-token' => $token,
        ])->get('https://openapi.5paisa.com/historical/n/c/1594/5m', [
            'from' => '2021-05-24',
            'end' => '2021-05-27',
        ]);
        dd($response);
        if ($response->successful()) {
            $data = $response->json();
            // Process the response data as needed
        } else {
            // Handle the request failure
        }

    }
}
