<?php

namespace App\Services;

use App\Helpers\Status;
use App\Models\Client;
use App\Models\Company;
use App\Models\StopList;

class PusherService
{
    static public function send($client_id){
        $client = Client::where('id', $client_id)->first();
        if (self::filter($client->number) == null && $client->status == 'dispatching'){
            $company = Company::where('id', $client->company_id)->first();
            $res =   i2CrmService::whatsapp($company, $client);
            self::save($res, $client_id);
        }elseif($client->status != 'done'){
            $client->status = 'on_stop_list';
            $client->save();
        }
    }
    static public function test(){
        $company = Company::where('status', 'dispatching')->first();
        $client = \App\Models\Client::where('company_id', $company->id)->where('status', 'dispatching')->first();
        if($client != null){
            self::send($client->id);
        }




    }
    static public function filter($phone){
        return StopList::where('number', $phone)->first();
    }

    static public function save($res, $client_id){
        $client = Client::where('id', $client_id)->first();
        $status = Status::res_client($res);
        if ($status != 'error_phone_banned'){
            Company::where('id', $client->company_id)->update([
                'status' => 'error_phone_banned'
            ]);
            Client::where('company_id', $client->company_id)->where('status', '!=', 'done')->update([
                'status' => 'error_phone_banned'
            ]);
        }
        $client->status = $status;
        $client->save();
    }
}
