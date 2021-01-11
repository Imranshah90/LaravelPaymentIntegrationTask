<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function initPayment(Request $request)
    {
        $reference = $request->get('reference');
        $amount = $request->get('amount');
        $data = $this->initPaymentAction($amount, $reference);

        $payment = auth()->user()->payments()->create([
            'amount' => $amount,
            'reference' => $reference,
            'status' => 'PENDING'
        ]);

        return view('payment-form', [
            'payment_data' => $data,
            'payment' => $payment
        ]);
    }

    public function makePayment(Request $request, Payment $payment)
    {
        $data = $this->getPaymentResponse();
        $result  = Arr::get($data, 'result', []);
        $status = Arr::get($result, 'code') === '000.100.110' ? 'COMPLETED' : 'FAILED';
        $payment->update([
            'payment_time' => now(),
            'payment_id' => Arr::get($data, 'id'),
            'status' => $status
        ]);

        $request->session()->flash('payment-status', $result);
        return redirect()->route('home');
    }

    private function getPaymentResponse()
    {
        $url = sprintf(
            'https://test.oppwa.com/v1/checkouts/%s/payment',
            request('id'),
        );

        $request = Http::withToken(config('services.copy_pay.access_token'))
            ->get($url, [
                'entityId' => config('services.copy_pay.entity_id')
            ]);

        return $request->json();
    }

    private function getPaymentData($amount, $reference)
    {
        $data = [
            'entityId' => config('services.copy_pay.entity_id'),
            'amount' => $amount,
            'merchantTransactionId' => $reference,
            'currency' => config('services.copy_pay.currency'),
            "paymentType" => 'DB',
        ];
        $str = '';
        foreach ($data as $key => $value) {
            $prefix = '';
            if ($str !== '') {
                $prefix = '&';
            }

            $str .= sprintf('%s%s=%s', $prefix, $key, $value);
        }

        return $str;
    }

    private function initPaymentAction($amount, $reference)
    {
        $url = config('services.copy_pay.gateway_url');
        $data = $this->getPaymentData($amount, $reference);

        $request = Http::withToken(config('services.copy_pay.access_token'))
            ->withBody($data, 'application/x-www-form-urlencoded')
            ->post($url);

        $response = $request->json();
        return $response;
    }
}
