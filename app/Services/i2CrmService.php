<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Phone;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class i2CrmService
{

    static public function whatsapp($company, $send){
        usleep((int)range(1000, 3000));
        if ($send->img_url != null){
            $body = [
                'domain' => 'whatsapp',
                'source' => $company->from_number,
                'client' => $send->number,
                'text' => $send->sms,
                'url' => $send->img_url
            ];
        }else{
            $body = [
                'domain' => 'whatsapp',
                'source' => $company->from_number,
                'client' => $send->number,
                'text' => $send->sms,
            ];
        }


        $token = Phone::where('phone', $company->from_number)->first()->token;
        if (config('app.env') == 'production'){
            try {
                $client = new Client();
                $headers = [
                    'Content-Type' => 'application/json'
                ];
                $request = new Request('POST', 'https://app.i2crm.ru/api_v1/target/feedback?key=' . $token, $headers, json_encode($body));
                $res = $client->sendAsync($request)->wait();
                return json_decode($res->getBody(), true);
            }catch (\Exception $e){
                Log::error($e->getMessage());
                return [
                    'error' => true,
                ];
            }
        }
        Log::info('logging', ['body' => $body, 'token' => $token]);
        return [
            'error' => false,
        ];
    }

}
