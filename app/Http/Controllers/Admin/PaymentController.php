<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')
            ->orderByDesc('payment_id')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Konfirmasi pembayaran:
     * - payments.status  → 'paid', paid_at diisi sekarang
     * - orders.status    → 'paid' juga (sinkron)
     */
    public function confirm($id)
    {
        $payment = Payment::findOrFail($id);

        DB::transaction(function () use ($payment) {
            // Update tabel payments
            $payment->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            // Sinkron status order ikut jadi 'paid'
            Order::where('order_id', $payment->order_id)
                ->update(['status' => 'paid']);
        });

        return redirect()->route('admin.payments.index')
            ->with('success', "Pembayaran #PAY-{$payment->payment_id} berhasil dikonfirmasi.");
    }
}