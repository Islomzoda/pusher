<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToModel, WithHeadingRow
{

    protected $company_id = '';
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!Client::where('company_id', $this->company_id)->where('number', $row['phone'])->first()){
            Company::where('id', $this->company_id)->update([
                'clients_count' => DB::raw('clients_count + 1'), // Увеличиваем на 1
                'status' => 'waiting_start', // Устанавливаем статус 'waiting_start'
            ]);
        }
        $client = Client::where('company_id', $this->company_id)->where('number', $row['phone'])->first();

        if (!$client || $client->status != 'done') {
            Client::updateOrCreate([
                'number' => $row['phone'],
                'company_id' => $this->company_id,
            ],
            [
                'number' => $row['phone'],
                'sms' => $row['text'],
                'img_url' => $row['url'],
                'company_id' => $this->company_id,
                'status' => 'new'
            ]);
        }

        return Client::updateOrCreate([
            'number' => $row['phone'],
            'company_id' => $this->company_id,
        ],
        [
            'number' => $row['phone'],
            'sms' => $row['text'],
            'img_url' => $row['url'],
            'company_id' => $this->company_id
        ]);
    }

    public  function heading(){

    }


}
