<?php
include '../classes/WorklogChecker.php';
include '../classes/JiraWorklogFormatter.php';
include '../classes/JiraConnector.php';
include '../classes/TroiWorklogFormatter.php';
include '../classes/TroiConnector.php';
include '../classes/RedmineWorklogFormatter.php';
include '../classes/RedmineConnector.php';

$worklogChecker = new WorklogChecker();
$jiraWorklogFormatter = new JiraWorklogFormatter();
$jiraConnector = new JiraConnector();
$troiWorklogFormatter = new TroiWorklogFormatter();
$troiConnector = new TroiConnector();
$redmineWorklogFormatter = new RedmineWorklogFormatter();
$redmineConnector = new RedmineConnector();

$date = $_POST['worklogDate'] ?? null;
$duration = $_POST['worklogDuration'] ?? null;
$note = $_POST['worklogNote'] ?? null;
$jiraChecked = $_POST['jiraChecked'] ?? null;
$troiChecked = $_POST['troiChecked'] ?? null;
$redmineChecked = $_POST['redmineChecked'] ?? null;

$troiHost = $_POST['troiHost'] ?? null;
$troiClient = $_POST['troiClient'] ?? null;
$troiCustomer = $_POST['troiCustomer'] ?? null;
$troiProject = $_POST['troiProject'] ?? null;
$troiBillingPosition = $_POST['troiBillingPosition'] ?? null;
$troiPrefix = $_POST['troiPrefix'] ?? null;
$troiPrefixText = null;

$jiraHost = $_POST['jiraHost'] ?? null;
$jiraProject = $_POST['jiraProject'] ?? null;
$jiraTicket = $_POST['jiraTicket'] ?? null;
$jiraTicketName = $_POST['jiraTicketName'] ?? null;

$redmineHost = $_POST['redmineHost'] ?? null;
$redmineProject = $_POST['redmineProject'] ?? null;
$redmineTicket = $_POST['redmineTicket'] ?? null;
$redmineActivity = $_POST['redmineActivity'] ?? null;

if(!$worklogChecker->inputsNotNull($date,$duration,$note)){
    $_SESSION['worklogMsg'] = 'Bitte fülle alle Felder aus.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if (!$worklogChecker->checkIfAnySystemIsChecked($jiraChecked, $troiChecked, $redmineChecked)) {
    $_SESSION['worklogMsg'] = 'Wähle bitte mindestens ein System aus, in das gebucht werden soll.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

$durationDecimal = $worklogChecker->convertTimeToDecimal($duration);

if($jiraChecked === 'true'){

    if ($troiPrefix === 'true' && $jiraTicketName !== 'none') {
        $troiPrefixText = 'Jira: ' . $jiraTicketName . ' ';
    }

    if($jiraWorklogFormatter->inputsNotNull($jiraHost,$jiraProject,$jiraTicket)){
        $spentSeconds = $jiraWorklogFormatter->calculateSpentSeconds($durationDecimal);

        if($jiraConnector->addWorklogToIssue($jiraHost,$jiraTicket,$note,$spentSeconds)) {
            $_SESSION['worklogJiraMsg'] = 'Jira Eintragung erfolgreich!';
        } else {
            $_SESSION['worklogJiraMsg'] = 'Jira Eintragung <strong>nicht</strong> erfolgreich!';
        }
    } else {
        $_SESSION['worklogJiraMsg'] = 'Jira Eintragung <strong>nicht</strong> erfolgreich! <br>Wähle bitte überall eine passende Option.';
    }
}

if ($redmineChecked === 'true') {

    if ($troiPrefix === 'true' && $redmineTicket !== null) {
        if ($troiPrefixText === null) {
            $troiPrefixText = 'Redmine: ' . $redmineTicket . ' ';
        } else {
            $troiPrefixText .= 'Redmine: ' . $redmineTicket . ' ';
        }
    }

    if ($redmineWorklogFormatter->inputsNotNull($redmineHost, $redmineProject, $redmineActivity)) {
        $redmineDate = $redmineWorklogFormatter->formatDate($date);

        if ($redmineConnector->addWorklog($redmineHost, $redmineProject, $redmineTicket, $redmineDate, $durationDecimal, $note, $redmineActivity)) {
            $_SESSION['worklogRedmineMsg'] = 'Redmine Eintragung erfolgreich!';
        } else {
            $_SESSION['worklogRedmineMsg'] = 'Redmine Eintragung <strong>nicht</strong> erfolgreich!';
        }
    } else {
        $_SESSION['worklogRedmineMsg'] = 'Redmine Eintragung <strong>nicht</strong> erfolgreich! <br>Gib mindestens die Verbindung, das Projekt und die Aktivität an.';
    }
}

if ($troiChecked === 'true') {
    if ($troiWorklogFormatter->inputsNotNull($troiHost, $troiClient, $troiBillingPosition)) {
        $troiDate = $troiWorklogFormatter->formatDate($date);
        $troiNote = $note;
        if ($troiPrefix != null && $troiPrefixText !== null) {
            $troiNote = $troiPrefixText . '- ' . $note;
        }
        if ($troiConnector->addWorklogToCalculitionPosition($troiHost, $troiClient, $troiBillingPosition, $troiDate, $troiNote, $durationDecimal)) {
            $_SESSION['worklogTroiMsg'] = 'Troi Eintragung erfolgreich!';
        } else {
            $_SESSION['worklogTroiMsg'] = 'Troi Eintragung <strong>nicht</strong> erfolgreich!';
        }
    } else {
        $_SESSION['worklogTroiMsg'] = 'Troi Eintragung <strong>nicht</strong> erfolgreich! <br>Gib mindestens die Verbindung, Mandanten und die Kalkulationsposition an.';
    }
}

header('Location: ../core/worklog.php');
