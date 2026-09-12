<?php

namespace App\Services\Contracts;

interface PaymentServiceInterface
{
    public function showByReservationId(int $reservationId);

    public function handleWebhook(string $orderId);
}
