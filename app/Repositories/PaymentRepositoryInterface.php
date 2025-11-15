<?php

namespace App\Repositories;

interface PaymentRepositoryInterface
{
    public function paymentWithWallet($request, $type);
    public function paymentWithPaypal($amount);
    public function paymentWithPayeer($request, $amount);
    public function paymentWithMidtrans($request, $amount);
    public function paymentWithMercadoPago($request);
    public function paymentWithInstamojo($amount);
    public function paymentWithMobilPay($amount);
    public function paymentWithStripe($request, $amount);
    public function paymentWithRazorPay($request);
    public function paymentWithPayTM(array $userData);
    public function paymentWithPayStack();
    public function paymentWithRazerMS($amount);
    public function paymentWithPesapal($amount, $type = 'payment');
    public function payWithGateWay();
}
