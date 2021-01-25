<?php
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';
include_once '../classes/iDBConnections.php';

class DBJiraConnections extends DBActions implements iDBConnections
{
    public function createJiraConnection($connectionName, $userId, $host, $username, $passOrToken, $apiVThree): bool
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('INSERT INTO `JiraAuthData`(`uid`, `name`, `host`, `user`, `password`, `apiv3`) VALUES (:uid, :name, :host, :username, :password, :apiVThree)');
            $sel->bindValue(':uid', $userId);
            $sel->bindValue(':name', $connectionName);
            $sel->bindValue(':host', $host);
            $sel->bindValue(':username', $this->encryptValue($username));
            $sel->bindValue(':password', $this->encryptValue($passOrToken));
            $sel->bindValue(':apiVThree', $apiVThree);
            if ($sel->execute()) {
                $this->createLogger()->debug('User created JiraConnection: UserID: ' . $userId . ' ConnectionName: ' . $connectionName);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not create JiraConnection: UserId: ' . $userId . ' ConnectionName: ' . $connectionName . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function createJiraConnection($connectionName, $userId, $host, $username, $passOrToken, $apiVThree): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function updateJiraConnection($id, $userid, $connectionName, $host, $username, $passOrToken, $apiVThree)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `JiraAuthData` SET `name` = :name, `host` = :host, `user` = :user, `password` = :password, `apiv3` = :apiVThree WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':name', $connectionName);
            $sel->bindValue(':host', $host);
            $sel->bindValue(':user', $this->encryptValue($username));
            $sel->bindValue(':password', $this->encryptValue($passOrToken));
            $sel->bindValue(':apiVThree', $apiVThree);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated JiraConnection: ConnectionID: ' . $id);
                return true;
            }

            if (!$sel->execute()) {
                $error = $sel->errorInfo();
                $this->createLogger()->error('User could not update JiraConnection: ConnectionID: ' . $id . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
                return false;
            }
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function updateJiraConnection($id, $connectionName, $userid, $host, $username, $passOrToken, $apiVThree): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }

    }

    public function getAllConnectionsByUid($userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `JiraAuthData` WHERE `uid` = :uid ORDER BY `name`;');
            $sel->bindValue(':uid', $userid);
            $sel->execute();
            $this->createLogger()->debug('User got JiraConnection: getAllConnectionsByUid($userid) userid=' . $userid);
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
            $sel = $con->prepare('SELECT * FROM `JiraAuthData` WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $uid);
            $sel->execute();
            $this->createLogger()->debug('User got JiraConnection: getConnectionById($id, $uid) id=' . $id . 'uid=' . $uid);
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
            $sel = $con->prepare('DELETE FROM `JiraAuthData` WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $userid);
            if ($sel->execute()) {
                $this->createLogger()->debug('User deleted JiraConnection: ConnectionID: ' . $id);
                return true;
            } elseif (!$sel->execute()) {
                $error = $sel->errorInfo();
                $this->createLogger()->warning('User could not delete JiraConnection: ConnectionID: ' . $id . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
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
            $sel = $con->prepare('SELECT `name`, `id` FROM `JiraAuthData` WHERE `uid` = :userId;');
            $sel->bindValue(':userId', $userid);
            $sel->execute();
            $this->createLogger()->debug('User got all JiraConnection names and ids: getAllConnectionNamesAndIdsByUid($userid): userid=' . $userid);
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function getAllConnectionNamesAndIdsByUid($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}