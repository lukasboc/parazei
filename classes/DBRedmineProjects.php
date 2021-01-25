<?php
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';

class DBRedmineProjects extends DBActions
{

    public function create($userid, $globalProjectId, $redmineConnection, $redmineProject, $redmineActivity)
    {
        try {
            $insert = $this->createConnection()->prepare('INSERT INTO RedmineProjects (`uid`, `globalProjectsId`, `connectionId`, `projectId`, `activityId`) VALUES (:uid, :globalProjectId, :connectionId, :projectId, :activityId)');
            $insert->bindValue(':uid', $userid);
            $insert->bindValue(':globalProjectId', $globalProjectId);
            $insert->bindValue(':connectionId', $redmineConnection);
            $insert->bindValue(':projectId', $redmineProject);
            $insert->bindValue(':activityId',$redmineActivity);
            if ($insert->execute()) {
                $this->createLogger()->debug('RedmineProject created. create()');
                return true;
            }
            $error = $insert->errorInfo();
            $this->createLogger()->warning('RedmineProject NOT created. create() Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function RedmineProjects. create(): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getProjectByGlobalProjectIdAndUserID($globalProjectID, $userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `RedmineProjects` WHERE `uid` = :uid AND `globalProjectsId` = :globalProjectId;');
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectId', $globalProjectID);
            $sel->execute();
            $this->createLogger()->debug('User got Redmine Project getProjectByGlobalProjectIdAndUserID($globalProjectID, $userid): uid=' . $userid);
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in RedmineProjects function getProjectByGlobalProjectIdAndUserID($globalProjectID, $userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function edit($redmineDBProjectId, $userid, $globalProjectId, $redmineConnection, $redmineProject, $redmineActivity)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `RedmineProjects` SET `connectionId` = :connectionId, `projectId` = :projectId, `activityId` = :activityId WHERE `id` = :id AND `uid` = :uid AND `globalProjectsId` = :globalProjectsId;');
            $sel->bindValue(':id', $redmineDBProjectId);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectsId', $globalProjectId);
            $sel->bindValue(':connectionId', $redmineConnection);
            $sel->bindValue(':activityId', $redmineActivity);
            $sel->bindValue(':projectId', $redmineProject);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated Global Project:  Redmine PID: ' . $redmineDBProjectId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not update Global Project: Redmine PID: ' . $redmineDBProjectId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function RedmineProjects edit($id, $userid, $globalProjectName): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function delete($redmineDBProjectId, $userid, $globalProjectId)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('DELETE FROM `RedmineProjects` WHERE id = :id AND `uid` = :uid AND `globalProjectsId` = :globalProjectsId');
            $sel->bindValue(':id', $redmineDBProjectId);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectsId', $globalProjectId);
            if ($sel->execute()) {
                $this->createLogger()->debug('User deleted Redmine Project: Redmine PID: ' . $redmineDBProjectId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not delete Redmine Project:  Redmine PID: ' . $redmineDBProjectId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function RedmineProjects delete($redmineDBProjectId, $userid, $globalProjectId): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}