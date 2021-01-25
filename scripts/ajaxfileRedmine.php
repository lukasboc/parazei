<?php
include '../classes/RedmineConnector.php';
$rc = new RedmineConnector();

$request = 0;
$redmineHostId = null;
$projectId = null;
$activity = null;

if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

if (isset($_POST['redmineHostId'])) {
    $redmineHostId = $_POST['redmineHostId'];
}
if (isset($_POST['projectId'])) {
    $projectId = $_POST['projectId'];
}
if (isset($_POST['redmineActivity'])) {
    $activity = $_POST['redmineActivity'];
}

// Fetch Project list by Connection ID
if ($request === 'redmineProjects') {
    $projects = $rc->getProjectsByConnectionId($redmineHostId);

    $response = array();
    foreach ($projects['projects'] as $p) {
        $response[] = array(
            "id" => $p['id'],
            "name" => $p['name']
        );
    }

    echo json_encode($response);
    exit;
}

// Fetch Tickets list by projectID
if ($request === 'redmineTickets') {
    $issues = $rc->getTicketsByProjectId($redmineHostId, $projectId);

    $response = array();
    foreach ($issues['issues'] as $p) {
        $response[] = array(
            "id" => $p['id'],
            "subject" => $p['subject'],
            "author" => $p['author']['name'],
        );
    }

    echo json_encode($response);
    exit;
}

// Fetch Activities Connection
if ($request === 'redmineActivities') {
    $activities = $rc->getActivitiesByConnectionId($redmineHostId);

    $response = array();
    foreach ($activities['time_entry_activities'] as $p) {
        $response[] = array(
            "id" => $p['id'],
            "name" => $p['name']
        );
    }

    echo json_encode($response);
    exit;
}