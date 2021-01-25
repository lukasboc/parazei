<?php
class TroiWorklogFormatter
{
    public function inputsNotNull($hostId, $clientId, $billingPosition): bool
    {
        return !($hostId == null || $clientId == null || $billingPosition == null);
    }

    public function formatDate($date)
    {
        return date("Y-m-d", strtotime($date));
    }

    public function calculateQuantity($startTime, $endTime)
    {
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        return (($end - $start) / 3600);
    }
}