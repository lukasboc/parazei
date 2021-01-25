<?php


class TroiProjectsChecker
{
    public function checkIfInputsNotNull($connection,$client,$customer, $project){
        if($connection !== null && $client !== null && $customer !== null && $project !== null) {
            return true;
        }
        else {
            return false;
        }
    }
}