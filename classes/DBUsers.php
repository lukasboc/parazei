<?php
require __DIR__ . '/../vendor/autoload.php';
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';

use Noodlehaus\Config;

class DBUsers extends DBActions
{
    public function login($mail, $password): bool
    {
        try {
            $select = $this->createConnection()->prepare('SELECT `email`, `password` FROM Users WHERE `email` = :email');
            $select->bindValue(':email', $mail);
            $select->execute();
            $userdata = $select->fetch();
            if (password_verify($password . $this->getEncryptionKey()->saveToAsciiSafeString(), $userdata['password'])) {
                $this->createLogger()->debug('user login successful. login($mail, $password) Mail: ' . $mail);
                return true;
            }
            $this->createLogger()->warning('user login unsuccessful. login($mail, $password) Mail: ' . $mail);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function login($mail, $password): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function register($mail, $password): bool
    {
        $conf = new Config('../config/general-config.php');
        if ($conf->get('allowRegistrations') !== 'true') {
            return false;
        }
        try {
            $hash = password_hash($password . $this->getEncryptionKey()->saveToAsciiSafeString(), PASSWORD_BCRYPT, array('cost' => 15));
            $insert = $this->createConnection()->prepare('INSERT INTO Users (`password`, `email`) VALUES (:password, :email)');
            $insert->bindValue(':password', $hash);
            $insert->bindValue(':email', $mail);
            if ($insert->execute()) {
                $this->createLogger()->debug('User registration successful. register($mail, $password) Mail: ' . $mail);
                return true;
            }
            $error = $insert->errorInfo();
            $this->createLogger()->warning('User could not Register. register($mail, $password) Mail: ' . $mail . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function register(mail, password): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getUserIdByMail($mail)
    {
        try {
            $select = $this->createConnection()->prepare('SELECT `id` FROM Users WHERE `email` = :email');
            $select->bindValue(':email', $mail);
            $select->execute();
            $userdata = $select->fetch();
            if ($userdata !== null) {
                return $userdata[0];
            }
            $this->createLogger()->info('User not found. getUserIdByMail($mail) Mail: ' . $mail);
            return null;

        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function getUserIdByMail(mail): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function checkPasswordByUid($userId, $password): bool
    {
        try {
            $select = $this->createConnection()->prepare('SELECT `password` FROM Users WHERE `id` = :id');
            $select->bindValue(':id', $userId);
            $select->execute();
            $userdata = $select->fetch();
            if (password_verify($password . $this->getEncryptionKey()->saveToAsciiSafeString(), $userdata['password'])) {
                $this->createLogger()->debug('CheckPassword true. checkPasswordByUid($userId, $password) UserID: ' . $userId);
                return true;
            }
            $this->createLogger()->info('CheckPassword false. UserID: ' . $userId);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function checkPassword(userId, password): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getMailByUserId($userid)
    {
        try {
            $select = $this->createConnection()->prepare('SELECT `email` FROM Users WHERE `id` = :id');
            $select->bindValue(':id', $userid);
            $select->execute();
            $userdata = $select->fetch();
            if ($userdata !== null) {
                return $userdata[0];
            }
            $this->createLogger()->warning('User not found. getMailByUserId($userid) ID: ' . $userid);
            return null;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function getMailByUserId(id): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function updateMailOfUser($userId, $newMail): bool
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `Users` SET `email` = :mail WHERE `id` = :id;');
            $sel->bindValue(':id', $userId);
            $sel->bindValue(':mail', $newMail);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated mail. getMailByUserId($userid) UserID: ' . $userId . ' NewMail: ' . $newMail);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->warning('User could not update mail: getMailByUserId($userid) UserID: ' . $userId . ' NewMail: ' . $newMail . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function updateMailOfUser(userId,newMail): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function updatePasswordOfUser($userId, $newPassword)
    {
        try {
            $hash = password_hash($newPassword . $this->getEncryptionKey()->saveToAsciiSafeString(), PASSWORD_BCRYPT, array('cost' => 15));
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `Users` SET `password` = :password WHERE `id` = :id;');
            $sel->bindValue(':id', $userId);
            $sel->bindValue(':password', $hash);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated password. UserID: ' . $userId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->warning('User could not update password: updatePasswordOfUser($userId, $newPassword) UserID: ' . $userId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function updatePasswordOfUser(userid,newPassword): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}