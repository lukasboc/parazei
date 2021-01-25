<?php

class PasswordChecker
{
    public function checkIfInputsFitRequirements($mailOrCurrentPass, $passwordOne, $passwordTwo): bool
    {
        if ($this->checkIfNullInputExists($mailOrCurrentPass, $passwordOne, $passwordTwo)) {
            $_SESSION['ErrMsg'] = 'Bitte fülle alle Felder aus.';
            return false;
        }
        if (!$this->checkIfPasswordsMatch($passwordOne, $passwordTwo)) {
            $_SESSION['ErrMsg'] = 'Die Passwörter stimmten nicht überein.';
            return false;
        }
        if (!$this->checkIfPasswordLengthIsOk($passwordOne)) {
            $_SESSION['ErrMsg'] = 'Passwort zu kurz.';
            return false;
        }
        if (!$this->checkIfPasswordContainsNumeric($passwordOne)) {
            $_SESSION['ErrMsg'] = 'Zu wenig numerische Zeichen. (Min. 1)';
            return false;
        }
        if (!$this->checkIfPasswordContainsAlphabetic($passwordOne)) {
            $_SESSION['ErrMsg'] = 'Zu wenig alphabetische Zeichen.';
            return false;
        }
        return true;
    }

    private function checkIfNullInputExists($inputOne, $inputTwo, $inputThree): bool
    {
        return $inputOne == null || $inputTwo == null || $inputThree == null;
    }

    private function checkIfPasswordsMatch($passwordOne, $passwordTwo): bool
    {
        return $passwordOne == $passwordTwo;
    }

    private function checkIfPasswordLengthIsOk($password): bool
    {
        return strlen($password) > 7;
    }

    private function checkIfPasswordContainsNumeric($password): bool
    {
        if (preg_match("#[0-9]+#", $password)) {
            return true;
        }
        return false;
    }

    private function checkIfPasswordContainsAlphabetic($password): bool
    {
        if (preg_match("#[a-zA-Z]+#", $password)) {
            return true;
        }
        return false;
    }

}