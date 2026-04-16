<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Facades\Http;

class ResiController extends Controller
{
    public function index()
    {
        return view('cek-resi');
    }

    public function check(Request $request)
    {
        $request->validate([
            'awb' => 'required',
            'courier' => 'required'
        ]);

        $apiKey = env('BINDERBYTE_API_KEY');

        //Siapkan parameter dasar
        $params = [
            'api key' => $apiKey,
            'courier' => $request->courier,
            'awb'     => $request->awb
        ];

        // Jika user mengisi nomor HP, tambahkan ke parameter history
        if ($request->filled('phone')) {
        $params['history'] = $request->phone;
        }
        
        $response = Http::get("https://api.binderbyte.com/v1/track",$params);
        $data = $respons->json();

        return redirect('/cek-resi')->with('result', $data);
    }
}