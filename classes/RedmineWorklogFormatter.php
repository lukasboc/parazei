<?php

class RedmineWorklogFormatter
{
    const LOWEST_POSSIBLE_QUANTITY = 0.25;
    //Round to next 900 Seconds (15 Minutes)
    const ROUND_INTERVAL = 900;
    //1 Hour in Seconds
    const ONE_HOUR_IN_SECONDS = 3600;


    public function inputsNotNull($hostId, $projectId, $activity): bool
    {
        return !($hostId == null || $projectId == null || $activity == null);
    }

    public function formatDate($date)
    {
        return date("Y-m-d", strtotime($date));
    }
}