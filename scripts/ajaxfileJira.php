<?php
include '../classes/JiraConnector.php';
$jc = new JiraConnector();

$request = 0;
$jiraHostId = null;
$projectId = null;

if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

if (isset($_POST['jiraHostId'])) {
    $jiraHostId = $_POST['jiraHostId'];
}
if (isset($_POST['projectId'])) {
    $projectId = $_POST['projectId'];
}

// Fetch Project list by Connection ID
if ($request === 'jiraProjects') {
    $projects = $jc->getProjectsByConnectionId($jiraHostId);

    $response = array();
    foreach ($projects as $p) {
        $response[] = array(
            "id" => $p->id,
            "name" => $p->name
        );
    }

    echo json_encode($response);
    exit;
}

// Fetch Tickets list by projectID
if ($request === 'jiraTickets') {
    $tickets = $jc->getTicketsByProjectId($jiraHostId, $projectId);

    $response = array();
    foreach ($tickets as $p) {
        $response[] = array(
            "id" => $p->id,
            "name" => $p->key,
            "summary" => $p->fields->summary
        );
    }

	echo json_encode($response);
	exit;
}