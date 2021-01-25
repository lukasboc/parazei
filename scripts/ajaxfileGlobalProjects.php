<?php
require_once 'inc/session.php.inc';
include_once '../classes/DBGlobalProjects.php';
include_once '../classes/DBJiraProjects.php';
include_once '../classes/DBTroiProjects.php';
include_once '../classes/DBRedmineProjects.php';

$dbGlobalProjects = new DBGlobalProjects();
$dbJiraProjects = new DBJiraProjects();
$dbTroiProjects = new DBTroiProjects();
$dbRedmineProjects = new DBRedmineProjects();

$request = 0;
$globalProjectsSelectId = null;

if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

if (isset($_POST['globalProjectsSelectId'])) {
    $globalProjectsSelectId = $_POST['globalProjectsSelectId'];
}


// Fetch Project list by Connection ID
if ($request === 'globalProjects') {
    $jiraProject = $dbJiraProjects->getProjectByGlobalProjectIdAndUserID($globalProjectsSelectId, $_SESSION['userid']);
    $troiProject = $dbTroiProjects->getProjectByGlobalProjectIdAndUserID($globalProjectsSelectId, $_SESSION['userid']);
    $redmineProject = $dbRedmineProjects->getProjectByGlobalProjectIdAndUserID($globalProjectsSelectId, $_SESSION['userid']);

    if (empty($jiraProject)) {
        $jiraProject = null;
    } else $jiraProject = $jiraProject[0];
    if (empty($troiProject)) {
        $troiProject = null;
    } else $troiProject = $troiProject[0];
    if (empty($redmineProject)) {
        $redmineProject = null;
    } else $redmineProject = $redmineProject[0];

    $response = array(
        "jira" => $jiraProject,
        "troi" => $troiProject,
        "redmine" => $redmineProject
    );
    echo json_encode($response);
    exit;
}
