<?php
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';

class DBGlobalProjects extends DBActions
{

    public function create($userId,$globalProjectName)
    {
        try {
            $insert = $this->createConnection()->prepare('INSERT INTO GlobalProjects (`uid`, `name`) VALUES (:uid, :name)');
            $insert->bindValue(':uid', $userId);
            $insert->bindValue(':name', $globalProjectName);
            if ($insert->execute()) {
                $this->createLogger()->debug('GlobalProject created. create($userId,$globalProjectName)');
                return true;
            }
            $error = $insert->errorInfo();
            $this->createLogger()->warning('GlobalProject NOT created. create($userId,$globalProjectName) Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function GlobalProjects. create($userId,$globalProjectName): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getLastInsertedProjectId()
    {
        try {
            $id= $this->getConnection()->lastInsertId();
            return $id;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function GlobalProject. getLastInsertedProjectId(): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }

    }

    public function getAllGlobalProjectsByUserID($userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `GlobalProjects` WHERE `uid` = :uid ORDER BY `name`;');
            $sel->bindValue(':uid', $userid);
            $sel->execute();
            $this->createLogger()->debug('User got all GlobalProjects getAllGlobalProjectsByUserID($userid): uid=' . $userid);
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in GlobalProjects function getAllGlobalProjectsByUserID($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getProjectNameById($id,$userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `GlobalProjects` WHERE `uid` = :uid AND `id` = :id ;');
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':id', $id);
            $sel->execute();
            $this->createLogger()->debug('User got all GlobalProjects getAllGlobalProjectsByUserID($userid): uid=' . $userid);
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in GlobalProjects function getAllGlobalProjectsByUserID($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function edit($id, $userid, $globalProjectName)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `GlobalProjects` SET `name` = :name WHERE `id` = :id AND `uid` = :uid;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':name', $globalProjectName);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated Global Project: PID: ' . $id);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not update Global Project: PID: ' . $id . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function edit($id, $userid, $globalProjectName): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function delete($globalProjectId, $userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('DELETE FROM `GlobalProjects` WHERE id = :id AND `uid` = :uid');
            $sel->bindValue(':id', $globalProjectId);
            $sel->bindValue(':uid', $userid);
            if ($sel->execute()) {
                $this->createLogger()->debug('User deleted Global Project: Global PID: ' . $globalProjectId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not delete Global Project:  Global PID: ' . $globalProjectId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function GlobalProjects delete($globalProjectId, $userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}