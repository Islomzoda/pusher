<?php

namespace App\Http\Controllers;

use App\Exports\ClientExport;
use App\Imports\ClientImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{



    public function fileImport(Request $request)
    {
        Excel::import(new ClientImport($request->company_id), $request->file('file')->store('temp'));
        return back();
    }

    public function fileExport(Request $request)
    {
        return Excel::download(new ClientExport($request->company_id), 'client.xlsx');
    }

}
