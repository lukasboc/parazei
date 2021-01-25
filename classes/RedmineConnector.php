<?php
require_once 'inc/session.php.inc';
include_once 'DBRedmineConnections.php';
require __DIR__ . '/../vendor/autoload.php';
include_once 'PMSActions.php';

class RedmineConnector extends PMSActions
{
    private function getAuthDataByConnectionId($connectionId)
    {
        $dbRedmineConnections = new DBRedmineConnections();
        $authData = $dbRedmineConnections->getConnectionById($connectionId, $_SESSION['userid']);
        return $authData;
    }

    public function getProjectsByConnectionId($connectionId): ?array
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $client = new Redmine\Client($authData[0]['host'], $authData[0]['user'], $authData[0]['password']);

            return $client->project->all();
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in RedmineConnector getProjectsByConnectionId($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        }
    }

    public function getTicketsByProjectId($connectionId, $projectId): ?array
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $client = new Redmine\Client($authData[0]['host'], $authData[0]['user'], $authData[0]['password']);

            return $client->issue->all(['project_id' => $projectId]);
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in RedmineConnector getTicketsByProjectId($connectionId, $projectId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        }
    }

    public function getActivitiesByConnectionId($connectionId): ?array
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $client = new Redmine\Client($authData[0]['host'], $authData[0]['user'], $authData[0]['password']);

            return $client->time_entry_activity->all();
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in RedmineConnector getActivitiesByConnectionId($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        }
    }

    public function addWorklog($redmineConnection, $redmineProject, $redmineTicket, $redmineDate, $redmineDuration, $redmineComment, $redmineActivity): bool
    {
        $authData = $this->getAuthDataByConnectionId($redmineConnection);
        if ($redmineTicket !== null) {
            return ($this->addWorklogToIssue($redmineConnection, $redmineTicket, $redmineDate, $redmineDuration, $redmineActivity, $redmineComment)) ? true : false;
        }
        if ($redmineProject !== null) {
            return ($this->addWorklogToProject($redmineConnection, $redmineProject, $redmineDate, $redmineDuration, $redmineActivity, $redmineComment)) ? true : false;
        }
        return false;
    }

    private function addWorklogToIssue($connectionId, $redmineTicket, $redmineDate, $redmineDuration, $redmineActivity, $redmineComment): ?bool
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $client = new Redmine\Client($authData[0]['host'], $authData[0]['user'], $authData[0]['password']);

            $created = $client->time_entry->create([
                'issue_id' => $redmineTicket,
                'spent_on' => $redmineDate,
                'hours' => $redmineDuration,
                'activity_id' => $redmineActivity,
                'comments' => $redmineComment,
            ]);
            return ($client->getResponseCode() == 201) ? true : false;

        } catch (Exception $e) {
            $this->createLogger()->error('Exception in RedmineConnector addWorklogToIssue($connectionId, $redmineTicket, $redmineDate, $redmineDuration, $redmineActivity, $redmineComment).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        }
    }

    private function addWorklogToProject($connectionId, $redmineProject, $redmineDate, $redmineDuration, $redmineActivity, $redmineComment): ?bool
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $client = new Redmine\Client($authData[0]['host'], $authData[0]['user'], $authData[0]['password']);

            $created = $client->time_entry->create([
                'project_id' => $redmineProject,
                'spent_on' => $redmineDate,
                'hours' => $redmineDuration,
                'activity_id' => $redmineActivity,
                'comments' => $redmineComment,
            ]);
            return ($client->getResponseCode() == 201) ? true : false;

        } catch (Exception $e) {
            $this->createLogger()->error('Exception in RedmineConnector addWorklogToProject($connectionId, $redmineProject, $redmineDate, $redmineDuration, $redmineActivity, $redmineComment).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        }
    }

    public function testConnection($id)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($id);
            $client = new Redmine\Client($authData[0]['host'], $authData[0]['user'], $authData[0]['password']);
            return $client->user->getCurrentUser([
                'include' => [
                    'status'
                ],
            ]);
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in RedmineConnector getProjectsByConnectionId($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        }

    }


}