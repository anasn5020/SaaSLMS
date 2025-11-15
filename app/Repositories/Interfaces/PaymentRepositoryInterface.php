<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    public function totalEarning(): array;
    public function paymentList(object $request): object;
    public function paymentMethods(): object;
    public function savePayout(object $request): bool;
    function instructorRequestPayout(object $request) : bool;
}
