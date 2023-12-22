<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientExport implements FromCollection
{
    protected $company_id = '';
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::where('company_id', $this->company_id)->get([
            'number',
            'sms',
            'img_url',
            'status'
        ]);
    }


}
