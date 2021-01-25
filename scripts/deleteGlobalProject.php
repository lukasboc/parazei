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
if ($globalProjectId !== "") {
    if ($dbGlobalProjects->delete($globalProjectId, $_SESSION['userid'])) {
        $jiraError = !$dbJiraProjects->delete($jiraDBProjectId, $_SESSION['userid'], $globalProjectId);
        $redmineError = !$dbRedmineProjects->delete($redmineDBProjectId, $_SESSION['userid'], $globalProjectId);
        $troiError = !$dbTroiProjects->delete($troiDBProjectId, $_SESSION['userid'], $globalProjectId);
    }
    if ($jiraError) {
        $_SESSION['jiraErrMsg'] = 'Fehler beim löschen des Jira Projekts.';
    }
    if ($redmineError) {
        $_SESSION['redmineErrMsg'] = 'Fehler beim löschen des Redmine Projekts.';
    }
    if ($troiError) {
        $_SESSION['troiErrMsg'] = 'Fehler beim löschen des Troi Projekts.';
    }
    $_SESSION['projectsMsg'] = 'Globles Projekt erfolgreich gelöscht.';
    header('Location: ../core/global-projects.php');
    die();
} else {
    $_SESSION['projectsMsg'] = 'Es wurde <strong>kein</strong> Projekt gelöscht. Versuche es erneut.';
    header('Location: ../core/global-projects.php');
    die();
}