<?php
include_once '../classes/DBConnector.php';
include_once '../classes/DBActions.php';

class DBTroiProjects extends DBActions
{

    public function create($userid, $globalProjectId, $troiConnection, $troiClient, $troiCustomer, $troiProject)
    {
        try {
            $insert = $this->createConnection()->prepare('INSERT INTO TroiProjects (`uid`, `globalProjectsId`, `connectionId`, `clientId`, `customerId`, `projectId`) VALUES (:uid, :globalProjectId, :connectionId, :clientId, :customerId, :projectId)');
            $insert->bindValue(':uid', $userid);
            $insert->bindValue(':globalProjectId', $globalProjectId);
            $insert->bindValue(':connectionId', $troiConnection);
            $insert->bindValue(':clientId', $troiClient);
            $insert->bindValue(':customerId', $troiCustomer);
            $insert->bindValue(':projectId', $troiProject);
            if ($insert->execute()) {
                $this->createLogger()->debug('TroiProject created. create()');
                return true;
            }
            $error = $insert->errorInfo();
            $this->createLogger()->warning('Troiroject NOT created. create() Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function TroiProjects. create(): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function getProjectByGlobalProjectIdAndUserID($globalProjectID, $userid)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('SELECT * FROM `TroiProjects` WHERE `uid` = :uid AND `globalProjectsId` = :globalProjectId;');
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectId', $globalProjectID);
            $sel->execute();
            $this->createLogger()->debug('User got all GlobalProjects in DBTroiProjects getAllGlobalProjectsByUserID($userid): uid=' . $userid);
            return $sel->fetchAll();
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in GlobalProjects in DBTroiProjects function getAllGlobalProjectsByUserID($userid): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function edit($troiDBProjectId, $userid, $globalProjectId, $troiConnection, $troiClient, $troiCustomer, $troiProject)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('UPDATE `TroiProjects` SET `connectionId` = :connectionId, `clientId` = :clientId, `customerId` = :customerId, `projectId` = :projectId WHERE `id` = :id AND `uid` = :uid AND `globalProjectsId` = :globalProjectsId;');
            $sel->bindValue(':id', $troiDBProjectId);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectsId', $globalProjectId);
            $sel->bindValue(':connectionId', $troiConnection);
            $sel->bindValue(':clientId', $troiClient);
            $sel->bindValue(':customerId', $troiCustomer);
            $sel->bindValue(':projectId', $troiProject);
            if ($sel->execute()) {
                $this->createLogger()->debug('User updated Global Project: Jira PID: ' . $troiDBProjectId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not update Global Project:  Jira PID: ' . $troiDBProjectId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function JiraProjects edit($id, $userid, $globalProjectName): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }

    public function delete($troiDBProjectId, $userid, $globalProjectId)
    {
        try {
            $con = $this->createConnection();
            $sel = $con->prepare('DELETE FROM `TroiProjects` WHERE id = :id AND `uid` = :uid AND `globalProjectsId` = :globalProjectsId');
            $sel->bindValue(':id', $troiDBProjectId);
            $sel->bindValue(':uid', $userid);
            $sel->bindValue(':globalProjectsId', $globalProjectId);
            if ($sel->execute()) {
                $this->createLogger()->debug('User deleted Troi Project: Troi PID: ' . $troiDBProjectId);
                return true;
            }
            $error = $sel->errorInfo();
            $this->createLogger()->error('User could not delete Troi Project:  Troi PID: ' . $troiDBProjectId . ' Error: ' . $error[0] . ', ' . $error[1] . ', ' . $error[2]);
            return false;
        } catch (Exception $exception) {
            $this->createLogger()->error('Error in function TroiProjects delete($troiDBProjectId, $userid, $globalProjectId): ' . $exception->getMessage());
            echo 'Something went wrong: ' . $exception->getMessage();
        }
    }
}