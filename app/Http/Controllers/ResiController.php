<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $apiKey = config('services.binderbyte.api_key', env('BINDERBYTE_API_KEY'));

        if (empty($apiKey)) {
            return redirect('/cek-resi')->with('result', [
                'status' => 400,
                'message' => 'API key belum dikonfigurasi. Hubungi admin.',
            ]);
        }

        $params = [
            'api_key' => $apiKey,
            'courier' => $request->courier,
            'awb'     => $request->awb
        ];

        if ($request->filled('phone')) {
            $params['phone'] = $request->phone;
        }

        try {
            $response = Http::timeout(15)->get("https://api.binderbyte.com/v1/track", $params);

            Log::info('BinderByte API Response', [
                'status_code' => $response->status(),
                'body' => $response->body(),
                'params' => array_merge($params, ['api_key' => '***']),
            ]);

            if ($response->failed()) {
                $body = $response->json();
                $message = $body['message'] ?? 'API mengembalikan error (HTTP ' . $response->status() . '). Kemungkinan API key tidak valid atau kuota habis.';

                return redirect('/cek-resi')->with('result', [
                    'status' => $response->status(),
                    'message' => $message,
                ]);
            }

            $data = $response->json();

            return redirect('/cek-resi')->with('result', $data);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('BinderByte API Connection Error: ' . $e->getMessage());

            return redirect('/cek-resi')->with('result', [
                'status' => 500,
                'message' => 'Tidak dapat terhubung ke server pelacakan. Coba lagi nanti.',
            ]);
        } catch (\Exception $e) {
            Log::error('BinderByte API Error: ' . $e->getMessage());

            return redirect('/cek-resi')->with('result', [
                'status' => 500,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.',
            ]);
        }
    }
}