<?php
/**
 * Created by PhpStorm.
 * User: lukasbock
 * Date: 19.08.20
 * Time: 18:39
 */

class WorklogChecker
{
    const LOWEST_POSSIBLE_QUANTITY = 0.25;
    //Round to next 900 Seconds (15 Minutes)
    const ROUND_INTERVAL = 900;
    //1 Hour in Seconds
    const ONE_HOUR_IN_SECONDS = 3600;

    public function inputsNotNull($date, $duration, $note): bool
    {
        return !($date == null || $duration == null || $note == null);
    }

    public function convertTimeToDecimal($durationTime) {
        $start = strtotime('00:00');
        $end = strtotime($durationTime);
        if ((($end - $start) / self::ONE_HOUR_IN_SECONDS) <= self::LOWEST_POSSIBLE_QUANTITY) {
            return 0.25;
        }
        $roundedSeconds = ceil(($end - $start) / self::ROUND_INTERVAL) * self::ROUND_INTERVAL;
        return $roundedSeconds / self::ONE_HOUR_IN_SECONDS;
    }

    public function checkIfAnySystemIsChecked($jira, $troi, $redmine): bool
    {
        return $jira === 'true' || $troi === 'true' || $redmine === 'true';
    }
}