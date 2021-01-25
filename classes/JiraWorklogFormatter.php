<?php

class JiraWorklogFormatter
{
    public function inputsNotNull($hostId, $projectId, $ticketId):bool{
        return !($hostId == null || $projectId == null || $ticketId == null);
    }

    public function formatStartedDateTime($date, $startTime)
    {
        $formattedDate = date( "Y-m-d", strtotime( $date ) );
        $formattedTime = date('H:m',strtotime($startTime));
        return $formattedDate . ' ' . $formattedTime . ':00';
    }

    public function calculateSpentSeconds($duration)
    {
        return $duration*3600;
    }
}