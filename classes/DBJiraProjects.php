<?php
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';

class DBJiraProjects extends DBActions
{

    public function create($userid, $globalProjectId, $jiraConnection, $jiraProject)
    {
        try {
            $insert = $this->createConnection()->prepare('INSERT INTO JiraProjects (`uid`, `globalProjectsId`, `connectionId`, `projectId`) VALUES (:uid, :globalProjectId, :connectionId, :projectId)');
            $insert->bindValue(':uid', $userid);
            $insert->bindValue(':globalProjectId', $globalProjectId);
            $insert->bindValue(':connectionId', $jiraConnection);
            $insert->bindValue(':projectId', $jiraProject);
            if ($insert->execute()) {
                $this->createLogger()->debug('JiraProject created. create()');
                return true;
            }
            $error = $insert->errorInfo();
            $this->createLogger()->warning('JiraProject NOT created. create() Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function JiraProjects. create(): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getProjectByGlobalProjectIdAndUserID($globalProjectID, $userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `JiraProjects` WHERE `uid` = :uid AND `globalProjectsId` = :globalProjectId;');
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectId', $globalProjectID);
            $sel->execute();
            $this->createLogger()->debug('User got all GlobalProjects getAllGlobalProjectsByUserID($userid): uid=' . $userid);
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in GlobalProjects function getAllGlobalProjectsByUserID($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function edit($id, $userid, $globalProjectId, $jiraConnection, $jiraProject)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `JiraProjects` SET `connectionId` = :connectionId, `projectId` = :projectId WHERE `id` = :id AND `uid` = :uid AND `globalProjectsId` = :globalProjectsId;');
            $sel->bindValue(':id', $id);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectsId', $globalProjectId);
            $sel->bindValue(':connectionId', $jiraConnection);
            $sel->bindValue(':projectId', $jiraProject);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated Global Project: Jira PID: ' . $id);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not update Global Project:  Jira PID: ' . $id . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function JiraProjects edit($id, $userid, $globalProjectName): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function delete($jiraDBProjectId, $userid, $globalProjectId)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('DELETE FROM `JiraProjects` WHERE id = :id AND `uid` = :uid AND `globalProjectsId` = :globalProjectsId');
            $sel->bindValue(':id', $jiraDBProjectId);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectsId', $globalProjectId);
            if ($sel->execute()) {
                $this->createLogger()->debug('User deleted Jira Project: Jira PID: ' . $jiraDBProjectId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not delete Jira Project:  Jira PID: ' . $jiraDBProjectId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function JiraProjects delete($jiraDBProjectId, $userid, $globalProjectId): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}