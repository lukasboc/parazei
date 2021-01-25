<?php


class RedmineProjectsChecker
{
    public function checkIfInputsNotNull($connection, $project,$activity){
        if($connection !== null && $project !== null && $activity !== null) {
            return true;
        }
        else {
            return false;
        }
    }

}