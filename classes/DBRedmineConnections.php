<?php
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';
include_once '../classes/iDBConnections.php';

class DBRedmineConnections extends DBActions implements iDBConnections
{
    public function createRedmineConnection($connectionName, $userId, $host, $username, $password): bool
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('INSERT INTO `RedmineAuthData`(`uid`, `name`, `host`, `user`, `password`) VALUES (:uid, :name, :host, :username, :password)');
            $sel->bindValue(':uid', $userId);
            $sel->bindValue(':name', $connectionName);
            $sel->bindValue(':host', $host);
            $sel->bindValue(':username', $this->encryptValue($username));
            $sel->bindValue(':password', $this->encryptValue($password));
            if ($sel->execute()) {
                $this->createLogger()->debug('User created Redmine: UserID: ' . $userId . ' ConnectionName: ' . $connectionName);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not create Redmine: UserId: ' . $userId . ' ConnectionName: ' . $connectionName . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function createRedmineConnection($connectionName, $userId, $host, $username, $password): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function updateRedmineConnection($id, $userid, $connectionName, $host, $username, $password)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `RedmineAuthData` SET `name` = :name, `host` = :host, `user` = :user, `password` = :password WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':name', $connectionName);
            $sel->bindValue(':host', $host);
            $sel->bindValue(':user', $this->encryptValue($username));
            $sel->bindValue(':password', $this->encryptValue($password));
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated RedmineConnection: ConnectionID: ' . $id);
                return true;
            } elseif (!$sel->execute()) {
                $error = $sel->errorInfo();
                $this->createLogger()->error('User could not update RedmineConnection: ConnectionID: ' . $id . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
                return false;
            }
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function updateRedmineConnection($id, $connectionName, $userid, $host, $username, $password): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }

    }

    public function getAllConnectionsByUid($userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `RedmineAuthData` WHERE `uid` = :uid ORDER BY `name`;');
            $sel->bindValue(':uid', $userid);
            $sel->execute();
            $this->createLogger()->debug('User got all Redmine connections: getAllConnectionsByUid($userid): uid=' . $userid);
            $connections = $sel->fetchAll();
            foreach ($connections as &$connection) {
                $connection['user'] = $this->decryptValue($connection['user']);
                $connection['password'] = $this->decryptValue($connection['password']);
            }
            return $connections;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function getAllConnectionsByUid($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getConnectionById($id, $uid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `RedmineAuthData` WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $uid);
            $sel->execute();
            $this->createLogger()->debug('User got Redmine connection: getConnectionById($id, $uid): id=' . $id . ' uid=' . $uid);
            $connections = $sel->fetchAll();
            foreach ($connections as &$connection) {
                $connection['user'] = $this->decryptValue($connection['user']);
                $connection['password'] = $this->decryptValue($connection['password']);
            }
            return $connections;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function getConnectionById($id, $uid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function deleteConnection($id, $userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('DELETE FROM `RedmineAuthData` WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $userid);
            if ($sel->execute()) {
                $this->createLogger()->debug('User deleted RedmineConnection: ConnectionID: ' . $id);
                return true;
            } elseif (!$sel->execute()) {
                $error = $sel->errorInfo();
                $this->createLogger()->warning('User could not delete RedmineConnection: ConnectionID: ' . $id . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
                return false;
            }
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function deleteConnection($id, $userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getAllConnectionNamesAndIdsByUid($userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT `name`, `id` FROM `RedmineAuthData` WHERE `uid` = :userId;');
            $sel->bindValue(':userId', $userid);
            $sel->execute();
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function Redmine: getAllConnectionNamesAndIdsByUid($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}