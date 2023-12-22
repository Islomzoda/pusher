<?php

namespace App\Http\Controllers;

use App\Helpers\Generate;
use App\Models\Client;
use App\Models\Company;
use App\Models\Phone;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->name;

        $company =  Company::create(
            ['name' => $name]
        );

        return to_route('detail', ['id' => $company->id]);
    }


    public function list(Request $request)
    {
        $status = $request?->status;

        if ($status){
            $companies = Company::where('status', $status)->get();
        }else{
            $companies = Company::all();
        }
        return view('company.list', [
            'companies' => $companies
        ]);
    }


    public function detail(Request $request){
        $id =  $request->id;
        $company = Company::where('id', $id)->first();
        $clients = Client::where('company_id', $id)->paginate(10);
        $days = 0;
        if ($clients->first() && $clients->first()->send_at){
            $start_time = Carbon::parse($clients->first()->send_at);
            $days = $start_time->diffInDays($clients->last()->send_at) ;
        }


        return view('company.details', [
            'company' => $company,
            'clients' => $clients,
            'phones' =>  Phone::all(),
            'days' => $days
        ]);
    }

    public function save(Request $request){
        $company_id = $request->company_id;
        $days_of_week = json_encode($request->daysOfWeek);
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $interval_min = $request->interval_min;
        $interval_max = $request->interval_max;
        $start_day = $request->start_day;
        $from_number = $request->from_number;
        $service_name = $request->service_name;
        Company::where('id', $company_id)->update([
            'days_of_week' => $days_of_week,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'interval_min' => $interval_min,
            'interval_max' => $interval_max,
            'start_day' => $start_day,
            'from_number' => $from_number,
            'service_name' => $service_name
        ]);
        return back();
    }

    public function generate(Request $request){
        return Generate::save($request->id);
    }

    public function start(Request $request){
        Company::where('id', $request->id)->update([
            'status' => 'dispatching'
        ]);
        Client::where('company_id', $request->id)->update([
            'status' => 'dispatching'
        ]);
        return back();
    }
    public function stop(Request $request){
        Company::where('id', $request->id)->update([
            'status' => 'stopped'
        ]);
        Client::where('company_id', $request->id)->update([
            'status' => 'stopped'
        ]);
        return back();
    }
}
