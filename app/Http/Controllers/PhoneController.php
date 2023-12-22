<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function store(Request $request)
    {
        Phone::updateOrCreate([
            'phone' => $request->phone,
        ],
        [
                'phone' => $request->phone,
                'token' => $request->token,
        ]);
        return back();
    }

    public function list(){
        return view('phone.list', [
            'phones' => Phone::all()
        ]);
    }

    public function details(Request $request){
        return view('phone.details', [
            'phone' => Phone::where('id', $request->id)->first()
        ]);
    }

    public function remove(Request $request){
        Phone::where('id', $request->id)->first()->delete();
        return back();
    }
}
