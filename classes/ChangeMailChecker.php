<?php
require_once 'inc/session.php.inc';

class ChangeMailChecker
{
    public function checkIfInputsFitRequirements($newMail, $password): bool
    {
        if ($this->checkIfNullInputExists($newMail, $password)) {
            $_SESSION['mailMsg'] = 'Bitte fülle alle Felder aus.';
            return false;
        }
        if (!$this->checkIfPasswordIsCorrect($_SESSION['userid'], $password)) {
            $_SESSION['mailMsg'] = 'Falsches Passwort. Versuche es erneut.';
            return false;
        }
        return true;
    }


    private function checkIfNullInputExists($newMail, $password): bool
    {
        return ($newMail == null || $password == null);
    }

    private function checkIfPasswordIsCorrect($userId, $password): bool
    {
        include_once 'DBUsers.php';
        $dbUsers = new DBUsers();
        if ($dbUsers->checkPasswordByUid($userId, $password)) {
            return true;
        }
        return false;
    }
}