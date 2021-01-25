<?php


class JiraProjectsChecker
{
    public function checkIfInputsNotNull($connection, $project){
        if($connection !== null && $project !== null) {
            return true;
        }
        else {
            return false;
        }
    }

}