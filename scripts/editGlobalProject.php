<?php
require_once '../classes/JiraProjectsChecker.php';
require_once '../classes/TroiProjectsChecker.php';
require_once '../classes/RedmineProjectsChecker.php';
require_once '../classes/DBGlobalProjects.php';
require_once '../classes/DBJiraProjects.php';
require_once '../classes/DBRedmineProjects.php';
require_once '../classes/DBTroiProjects.php';
require 'inc/session.php.inc';

$jiraProjectsChecker = new JiraProjectsChecker();
$troiProjectsChecker = new TroiProjectsChecker();
$redmineProjectsChecker = new RedmineProjectsChecker();
$dbGlobalProjects = new DBGlobalProjects();
$dbJiraProjects = new DBJiraProjects();
$dbTroiProjects = new DBTroiProjects();
$dbRedmineProjects = new DBRedmineProjects();

$globalProjectId = $_POST['globalProjectId'] ?? null;
$globalProjectName = $_POST['globalProjectName'] ?? null;

$troiDBProjectId = $_POST['troiProjectId'] ?? null;
$troiConnection = $_POST['troiHost'] ?? null;
$troiClient = $_POST['troiClient'] ?? null;
$troiCustomer = $_POST['troiCustomer'] ?? null;
$troiProject = $_POST['troiProject'] ?? null;

$jiraDBProjectId = $_POST['jiraProjectId'] ?? null;
$jiraConnection = $_POST['jiraHost'] ?? null;
$jiraProject = $_POST['jiraProject'] ?? null;

$redmineDBProjectId = $_POST['redmineProjectId'] ?? null;
$redmineConnection = $_POST['redmineHost'] ?? null;
$redmineProject = $_POST['redmineProject'] ?? null;
$redmineActivity = $_POST['redmineActivity'] ?? null;

$isJiraProject = false;
$isRedmineProject = false;
$isTroiProject = false;

$jiraError = false;
$redmineError = false;
$troiError = false;


// Wenn kein globales Projet gesetzt ist, wird ein neues globales Projekt erstellt und neue PMS Projekte erstellt
if ($globalProjectId !== "" && ($troiConnection !== null || $jiraConnection !== null || $redmineConnection !== null)) {
    if ($jiraProjectsChecker->checkIfInputsNotNull($jiraConnection, $jiraProject)) {
        $isJiraProject = true;
    }
    if ($troiProjectsChecker->checkIfInputsNotNull($troiConnection, $troiClient, $troiCustomer, $troiProject)) {
        $isTroiProject = true;
    }
    if ($redmineProjectsChecker->checkIfInputsNotNull($redmineConnection, $redmineProject, $redmineActivity)) {
        $isRedmineProject = true;
    }
    //todo if pms not checked: delete pms projects where uid and globalpid
    if (($isJiraProject || $isRedmineProject || $isTroiProject) && $globalProjectName !== "") {
        if ($dbGlobalProjects->edit($globalProjectId, $_SESSION['userid'], $globalProjectName)) {
            if ($isJiraProject) {
                if ($jiraDBProjectId === "") {
                    $jiraError = !$dbJiraProjects->create($_SESSION['userid'], $globalProjectId, $jiraConnection, $jiraProject);
                } else $jiraError = !$dbJiraProjects->edit($jiraDBProjectId, $_SESSION['userid'], $globalProjectId, $jiraConnection, $jiraProject);
            } else {
                $jiraError = !$dbJiraProjects->delete($jiraDBProjectId, $_SESSION['userid'], $globalProjectId);
            }
            if ($isRedmineProject) {
                if ($redmineDBProjectId === "") {
                    $redmineError = !$dbRedmineProjects->create($_SESSION['userid'], $globalProjectId, $redmineConnection, $redmineProject, $redmineActivity);
                } else $redmineError = !$dbRedmineProjects->edit($redmineDBProjectId, $_SESSION['userid'], $globalProjectId, $redmineConnection, $redmineProject, $redmineActivity);
            } else {
                $redmineError = !$dbRedmineProjects->delete($redmineDBProjectId, $_SESSION['userid'], $globalProjectId);
            }
            if ($isTroiProject) {
                if ($troiDBProjectId === "") {
                    $troiError = !$dbTroiProjects->create($_SESSION['userid'], $globalProjectId, $troiConnection, $troiClient, $troiCustomer, $troiProject);
                } else $troiError = !$dbTroiProjects->edit($troiDBProjectId, $_SESSION['userid'], $globalProjectId, $troiConnection, $troiClient, $troiCustomer, $troiProject);
            } else {
                $troiError = !$dbTroiProjects->delete($troiDBProjectId, $_SESSION['userid'], $globalProjectId);
            }
            if ($jiraError) {
                $_SESSION['jiraErrMsg'] = 'Fehler beim Jira Projekt.';
            }
            if ($redmineError) {
                $_SESSION['redmineErrMsg'] = 'Fehler beim Redmine Projekt.';
            }
            if ($troiError) {
                $_SESSION['troiErrMsg'] = 'Fehler beim Troi Projekt.';
            }
            $_SESSION['projectsMsg'] = 'Globles Projekt erfolgreich geändert.';
            header('Location: ../core/global-projects.php');
            die();
        }
    }
} else {
    $_SESSION['projectsMsg'] = 'Es wurde <strong>kein</strong> Projekt geändert. Bitte stelle sicher, dass mindestens eine Erfassung pro globalem Projekt aktiviert ist.';
    header('Location: ../core/global-projects.php');
    die();
}