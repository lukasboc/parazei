<?php
require_once 'inc/session.php.inc';
require __DIR__ . '/../vendor/autoload.php';
include_once 'DBJiraConnections.php';
require_once 'PMSActions.php';

use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\Issue\Worklog;
use JiraRestApi\Issue\ContentField;
use JiraRestApi\JiraException;
use JiraRestApi\User\UserService;

class JiraConnector extends PMSActions
{
    private function getAuthDataByConnectionId($connectionId)
    {
        $dbJiraConnections = new DBJiraConnections();
        $authData = $dbJiraConnections->getConnectionById($connectionId, $_SESSION['userid']);
        if ($authData[0]['apiv3'] == 1) {
            $authData[0]['apiv3'] = 'true';
        } else {
            $authData[0]['apiv3'] = 'false';
        }
        return $authData;
    }

    public function getProjectsByConnectionId($connectionId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $proj = new ProjectService(new ArrayConfiguration(
                array(
                    'jiraHost' => $authData[0]['host'],
                    // for basic authorization:
                    'jiraUser' => $authData[0]['user'],
                    'jiraPassword' => $authData[0]['password'],
                    'useV3RestApi' => $authData[0]['apiv3'],
                )
            ));

            return $proj->getAllProjects();

        } catch (JiraRestApi\JiraException $e) {
            $this->createLogger()->error('JiraException in JiraConnector getProjectsByConnectionId($connectionId).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
            print('Error Occured! ' . $e->getMessage());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in JiraConnector getProjectsByConnectionId($connectionId).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
        }
    }

    public function getTicketsByProjectId($jiraHostId, $projectId)
    {
        $jql = 'project = ' . $projectId . ' order by created DESC';

        try {
            $authData = $this->getAuthDataByConnectionId($jiraHostId);
            $issueService = new IssueService(new ArrayConfiguration(
                array(
                    'jiraHost' => $authData[0]['host'],
                    // for basic authorization:
                    'jiraUser' => $authData[0]['user'],
                    'jiraPassword' => $authData[0]['password'],
                    'useV3RestApi' => $authData[0]['apiv3'],
                )
            ));
            $startAt = 0;
            $maxResult = -1; // In order to get all issues since the api default is 50
            $ret = $issueService->search($jql, $startAt, $maxResult);
            return $ret->getIssues();
        } catch (JiraRestApi\JiraException $e) {
            $this->createLogger()->error('JiraException in JiraConnector getTicketsByProjectId($jiraHostId, $projectId).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
            print('Error Occured! ' . $e->getMessage());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in JiraConnector getTicketsByProjectId($jiraHostId, $projectId).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
        }
    }

    public function addWorklogToIssue($jiraHostId, $issueKey, $summary, $timeSpentSeconds)
    {
        $authData = $this->getAuthDataByConnectionId($jiraHostId);
        if ($authData[0]['apiv3'] === 'true') {
            if ($this->addWorklogToIssueAPIVThree($jiraHostId, $issueKey, $summary, $timeSpentSeconds)) return true;
        } else {
            if ($this->addWorklogToIssueAPIVTwo($jiraHostId, $issueKey, $summary, $timeSpentSeconds)) return true;
        }
        return false;
    }

    private function addWorklogToIssueAPIVThree($jiraHostId, $issueKey, $summary, $timeSpentSeconds)
    {

        try {
            $workLog = new Worklog();

            $paragraph = new ContentField();
            $paragraph->type = 'paragraph';
            $paragraph->content[] = [
                'text' => $summary,
                'type' => 'text',
            ];

            $comment = new ContentField();
            $comment->type = 'doc';
            $comment->version = 1;
            $comment->content[] = $paragraph;

            $workLog->setComment($comment)
                ->setTimeSpentSeconds($timeSpentSeconds);

            $authData = $this->getAuthDataByConnectionId($jiraHostId);
            $issueService = new IssueService(new ArrayConfiguration(
                array(
                    'jiraHost' => $authData[0]['host'],
                    // for basic authorization:
                    'jiraUser' => $authData[0]['user'],
                    'jiraPassword' => $authData[0]['password'],
                    'useV3RestApi' => $authData[0]['apiv3'],
                )
            ));
            $ret = $issueService->addWorklog($issueKey, $workLog);

            $workLogid = $ret->{'id'};
            return $workLogid !== null;
        } catch (JiraRestApi\JiraException $e) {
            $this->createLogger()->error('JiraException in JiraConnector addWorklogToIssueAPIVThree($jiraHostId, $issueKey, $summary, $timeSpentSeconds).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
            print('Error Occured! ' . $e->getMessage());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in JiraConnector addWorklogToIssueAPIVThree($jiraHostId, $issueKey, $summary, $timeSpentSeconds).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
        }
    }

    private function addWorklogToIssueAPIVTwo($jiraHostId, $issueKey, $summary, $timeSpentSeconds)
    {
        try {
            $workLog = new Worklog();

            $workLog->setComment($summary)
                ->setTimeSpentSeconds($timeSpentSeconds);

            $authData = $this->getAuthDataByConnectionId($jiraHostId);
            $issueService = new IssueService(new ArrayConfiguration(
                array(
                    'jiraHost' => $authData[0]['host'],
                    // for basic authorization:
                    'jiraUser' => $authData[0]['user'],
                    'jiraPassword' => $authData[0]['password'],
                    'useV3RestApi' => $authData[0]['apiv3'],
                )
            ));

            $ret = $issueService->addWorklog($issueKey, $workLog);
            return $ret->id !== null;
        } catch (JiraRestApi\JiraException $e) {
            $this->createLogger()->error('JiraException in JiraConnector addWorklogToIssueAPIVTwo($jiraHostId, $issueKey, $summary, $startedDateTime, $timeSpentSeconds).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
            print('Error Occured! ' . $e->getMessage());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in JiraConnector addWorklogToIssueAPIVTwo($jiraHostId, $issueKey, $summary, $startedDateTime, $timeSpentSeconds).' . ' Error: ' . $e[0] . ', ' . $e[1] . ', ' . $e[2]);
        }
    }

    public function testConnection($connectionId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $usr = new UserService(new ArrayConfiguration(
                array(
                    'jiraHost' => $authData[0]['host'],
                    // for basic authorization:
                    'jiraUser' => $authData[0]['user'],
                    'jiraPassword' => $authData[0]['password'],
                    'useV3RestApi' => $authData[0]['apiv3'],
                )
            ));
            return $usr->getMyself();

        } catch (JiraRestApi\JiraException $e) {
            $this->createLogger()->error('JiraException in JiraConnector testConnection($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in JiraConnector testConnection($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
        }
    }
}