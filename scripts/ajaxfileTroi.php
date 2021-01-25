<?php
include '../classes/TroiConnector.php';
$tc = new TroiConnector();

$request = null;
$troiHostId = null;
$troiClient = null;
$troiCustomer = null;
$troiProject = null;

if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

if (isset($_POST['troiHostId'])) {
    $troiHostId = $_POST['troiHostId'];
}
if (isset($_POST['troiClient'])) {
    $troiClient = $_POST['troiClient'];
}
if (isset($_POST['troiCustomer'])) {
    $troiCustomer = $_POST['troiCustomer'];
}
if (isset($_POST['troiProject'])) {
    $troiProject = $_POST['troiProject'];
}

// Fetch state list by countryid
if ($request === 'troiClients') {
    $resp = $tc->getClientsByConnectionId($troiHostId);

    $response = array();
    foreach ($resp as $p) {
        $response[] = array(
            "id" => $p->id,
            "name" => $p->Name
        );
    }

    echo json_encode($response);
    exit;
}

// Fetch Customers list by ClientID
if ($request === 'troiCustomers') {
    $customers = $tc->getCustomersByClientId($troiHostId, $troiClient);

    $response = array();
    foreach ($customers as $p) {
        $response[] = array(
            "id" => $p->id,
            "name" => $p->Name
        );
    }
    echo json_encode($response);
    exit;
}

// Fetch Projects list by CustomerId
if ($request === 'troiProjects') {
    $projects = $tc->getProjectsByClientIdAndCustomerId($troiHostId, $troiClient, $troiCustomer);

    $response = array();
    foreach ($projects as $p) {
        $response[] = array(
            "id" => $p->id,
            "name" => $p->Name
        );
    }
    echo json_encode($response);
    exit;
}

// Fetch Calculation Positions By ProjectId
if ($request === 'calculationPositionsByProjectId') {
    $projects = $tc->getCalculationPositionsByClientIdAndProjectId($troiHostId, $troiClient, $troiProject);

    $response = array();
    foreach ($projects as $p) {
        if ($p->IsBillable) {
            $response[] = array(
                "id" => $p->id,
                "name" => $p->DisplayPath
            );
        }
    }
    echo json_encode($response);
    exit;
}

// Fetch Calculation Positions By ProjectId and ClientId
if ($request === 'calculationPositionsByClientId') {
    $projects = $tc->getCalculationPositionsByClientId($troiHostId, $troiClient);
    $response = array();
    if (is_array($projects) || is_object($projects)) {
        foreach ($projects as $p) {
            if ($p->IsBillable) {
                $response[] = array(
                    "id" => $p->id,
                    "name" => $p->DisplayPath
                );
            }
        }
    }
    echo json_encode($response);
    exit;
}