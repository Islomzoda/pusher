<?php

namespace App\Http\Controllers;

use App\Models\StopList;
use Illuminate\Http\Request;

class StopListController extends Controller
{
    public function store(Request $request)
    {
        StopList::updateOrCreate([
            'number' => $request->number,
        ],
            [
              'number' => $request->number,
            ]);
        return back();
    }

    public function list(){
        return view('stoplist.list', [
            'phones' => StopList::all()
        ]);
    }

    public function details(Request $request){
        return view('stoplist.details', [
            'phone' => StopList::where('id', $request->id)->first()
        ]);
    }

    public function remove(Request $request){
        StopList::where('id', $request->id)->first()->delete();
        return back();
    }
}
