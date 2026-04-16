<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $midtransOrderId   = $request->order_id;
        $transactionStatus = $request->transaction_status;
        $paymentType       = $request->payment_type ?? null;
        $fraudStatus       = $request->fraud_status ?? 'accept';

        $payment = Payment::where('midtrans_order_id', $midtransOrderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Map payment_type dari Midtrans ke label yang readable
        $method = $this->mapPaymentType($paymentType, $request);

        // Tentukan status
        $paymentStatus = 'pending';
        $orderStatus   = 'pending';
        $paidAt        = null;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $paymentStatus = 'paid';
                $orderStatus   = 'paid';
                $paidAt        = now();
            } else {
                $paymentStatus = 'failed';
                $orderStatus   = 'canceled';
            }
        } elseif ($transactionStatus === 'settlement') {
            $paymentStatus = 'paid';
            $orderStatus   = 'paid';
            $paidAt        = now();
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $paymentStatus = 'failed';
            $orderStatus   = 'canceled';
        }

        DB::transaction(function () use ($payment, $paymentStatus, $orderStatus, $paidAt, $method) {
            $payment->update([
                'status'  => $paymentStatus,
                'method'  => $method,
                'paid_at' => $paidAt,
            ]);

            Order::where('order_id', $payment->order_id)
                ->update(['status' => $orderStatus]);
        });

        return response()->json([
            'message'        => 'Status updated',
            'payment_status' => $paymentStatus,
            'method'         => $method,
        ]);
    }

    private function mapPaymentType(?string $paymentType, Request $request): string
    {
        return match($paymentType) {
            'bank_transfer'     => 'Bank Transfer - ' . strtoupper($request->va_numbers[0]['bank'] ?? ''),
            'echannel'          => 'Mandiri Bill',
            'bca_klikpay'       => 'BCA KlikPay',
            'cimb_clicks'       => 'CIMB Clicks',
            'danamon_online'    => 'Danamon Online',
            'credit_card'       => 'Kartu Kredit',
            'gopay'             => 'GoPay',
            'shopeepay'         => 'ShopeePay',
            'qris'              => 'QRIS',
            'cstore'            => ucfirst($request->store ?? 'Convenience Store'),
            'akulaku'           => 'Akulaku',
            'kredivo'           => 'Kredivo',
            default             => $paymentType ?? 'ewallet',
        };
    }
}