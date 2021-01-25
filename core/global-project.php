<?php
require 'inc/session.php.inc';
include_once '../classes/DBJiraProjects.php';
include_once '../classes/DBRedmineProjects.php';
include_once '../classes/DBTroiProjects.php';

include_once '../classes/DBTroiConnections.php';
include_once '../classes/DBJiraConnections.php';
include_once '../classes/DBRedmineConnections.php';

include_once '../classes/DBGlobalProjects.php';

$dbTroiConnections = new DBTroiConnections();
$dbJiraConnections = new DBJiraConnections();
$dbRedmineConnections = new DBRedmineConnections();
$dbGlobalProjects = new DBGlobalProjects();

$projectAction = $_POST['projectAction'] ?? null;

$id = null;
$name = null;

$jiraConnection = null;
$jiraProject = null;
$jiraDBId = null;

$redmineConnection = null;
$redmineProject = null;
$redmineActivity = null;
$redmineDBId = null;

$troiConnection = null;
$troiClient = null;
$troiCustomer = null;
$troiProject = null;
$troiDBId = null;


if (isset($_POST['globalProjectId']) || isset($_SESSION['globalProjectId'])) {
    if (isset($_POST['globalProjectId'])) {
        $id = $_POST['globalProjectId'];
    }
    if (isset($_SESSION['globalProjectId'])) {
        $id = $_SESSION['globalProjectId'];
        unset($_SESSION['globalProjectId']);
    }
    $jiraDBProjects = new DBJiraProjects();
    $redmineDBProjects = new DBRedmineProjects();
    $troiDBProjects = new DBTroiProjects();

    $globalProject = $dbGlobalProjects->getProjectNameById($id, $_SESSION['userid'])[0];
    if ($globalProject === null) {
        $_SESSION['projectsMsg'] = 'Hier ist etwas schiefgelaufen. Versuche es erneut.';
        header('Location: ../core/global-projects.php');
        die();
    }
    $name = $globalProject['name'];

    $jiraDBProject = $jiraDBProjects->getProjectByGlobalProjectIdAndUserID($id, $_SESSION['userid']);
    if ($jiraDBProject != null) {
        $jiraConnection = $jiraDBProject[0]['connectionId'];
        $jiraProject = $jiraDBProject[0]['projectId'];
        $jiraDBId = $jiraDBProject[0]['id'];
    }
    $troiDBProject = $troiDBProjects->getProjectByGlobalProjectIdAndUserID($id, $_SESSION['userid']);
    if ($troiDBProject != null) {
        $troiConnection = $troiDBProject[0]['connectionId'];
        $troiClient = $troiDBProject[0]['clientId'];
        $troiCustomer = $troiDBProject[0]['customerId'];
        $troiProject = $troiDBProject[0]['projectId'];
        $troiDBId = $troiDBProject[0]['id'];
    }

    $redmineDBProject = $redmineDBProjects->getProjectByGlobalProjectIdAndUserID($id, $_SESSION['userid']);
    if ($redmineDBProject != null) {
        $redmineConnection = $redmineDBProject[0]['connectionId'];
        $redmineProject = $redmineDBProject[0]['projectId'];
        $redmineActivity = $redmineDBProject[0]['activityId'];
        $redmineDBId = $redmineDBProject[0]['id'];
    }
}
?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css"/>
    <link rel="stylesheet" href="../vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Parazei | Globales Projekt</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Globales Projekt</h1>
    <form method="post">
        <input type="hidden" class="form-control" name="globalProjectId" id="globalProjectId"
               value="<?php if (isset($id)) {
                   echo $id;
               } ?>">
        <div class="form-group row">
            <label for="date" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" required name="globalProjectName" id="globalProjectName" class="form-control"
                           value="<?php if (isset($id)) {
                               echo $name;
                           } ?>"/>
                </div>
            </div>
        </div>
        <div class="form-group row mt-5">
            <div id="troiOptions" class="col-lg">
                <div class="custom-control custom-switch">
                    <input type="checkbox"
                           class="custom-control-input" <?php if ($troiDBId !== null) echo 'checked="checked"' ?>
                           id="troiSwitch" name="troiChecked" value="true">
                    <label class="custom-control-label select-pms-label" for="troiSwitch">Troi Erfassung</label>
                </div>
                <div class="form-group row">
                    <label for="troiHost" class="col-sm-4 col-form-label">Verbindung</label>
                    <input type="hidden" name="troiProjectId" id="troiProjectId"
                           value="<?php if ($troiDBId !== null) echo $troiDBId ?>">
                    <div class="col-sm-8">
                        <select id="troiHost" name="troiHost" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Auswählen..</option>
                            <?php
                            $projectNames = $dbTroiConnections->getAllConnectionNamesAndIdsByUid($_SESSION['userid']);
                            for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                if ($projectNames[$i]['id'] === $troiConnection) {
                                    echo '<option selected value="' . $projectNames[$i]['id'] . '">' . $projectNames[$i]['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $projectNames[$i]['id'] . '">' . $projectNames[$i]['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="troiClient" class="col-sm-4 col-form-label">Mandant</label>
                    <div class="col-sm-8">
                        <select id="troiClient" name="troiClient" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <?php
                            if (isset($id) && $troiDBId !== null) {
                                echo '<option value="null" disabled>Auswählen..</option>';
                                include_once '../classes/TroiConnector.php';
                                $troiConnector = new TroiConnector();
                                $projectNames = $troiConnector->getClientsByConnectionId($troiConnection);
                                for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                    if ($projectNames[$i]->id === $troiClient) {
                                        echo '<option selected value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->Name . '</option>';
                                    } else {
                                        echo '<option value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->Name . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="null" disabled selected>Auswählen..</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="troiCustomer" class="col-sm-4 col-form-label">Kunde</label>
                    <div class="col-sm-8">
                        <select id="troiCustomer" name="troiCustomer" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <?php
                            if (isset($id) && $troiDBId !== null) {
                                echo '<option value="null" disabled>Auswählen..</option>';
                                include_once '../classes/TroiConnector.php';
                                $troiConnector = new TroiConnector();
                                $projectNames = $troiConnector->getCustomersByClientId($troiConnection, $troiClient);
                                for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                    if ($projectNames[$i]->id === $troiCustomer) {
                                        echo '<option selected value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->Name . '</option>';
                                    } else {
                                        echo '<option value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->Name . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="null" disabled selected>Auswählen..</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="troiProject" class="col-sm-4 col-form-label">Projekt</label>
                    <div class="col-sm-8">
                        <select id="troiProject" name="troiProject" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <?php
                            if (isset($id) && $troiDBId !== null) {
                                echo '<option value="null" disabled>Auswählen..</option>';
                                include_once '../classes/TroiConnector.php';
                                $troiConnector = new TroiConnector();
                                $projectNames = $troiConnector->getProjectsByClientIdAndCustomerId($troiConnection, $troiClient, $troiCustomer);
                                for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                    if ($projectNames[$i]->id == $troiProject) {
                                        echo '<option selected value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->Name . '</option>';
                                    } else {
                                        echo '<option value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->Name . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="null" disabled selected>Auswählen..</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <select id="troiBillingPosition" name="troiBillingPosition" data-width="100%"
                                data-live-search="true"
                                class=" bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Auswählen..</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <input type="checkbox" hidden class="form-check-input" name="troiPrefix" id="troiPrefix"
                               value="true">
                    </div>
                </div>
            </div>
            <div id="jiraOptions" class="col-lg">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"
                           id="jiraSwitch" <?php if ($jiraDBId !== null) echo 'checked="checked"' ?> name="jiraChecked"
                           value="true">
                    <label class="custom-control-label select-pms-label" for="jiraSwitch">Jira Erfassung</label>
                </div>
                <div class="form-group row">
                    <label for="jiraHost" class="col-sm-4 col-form-label">Verbindung</label>
                    <input type="hidden" name="jiraProjectId" id="jiraProjectId"
                           value="<?php if ($jiraDBId !== null) echo $jiraDBId ?>">
                    <div class="col-sm-8">
                        <select id="jiraHost" name="jiraHost" data-width="100%" data-live-search="true"
                                class="jiraSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Auswählen..</option>
                            <?php
                            $projectNames = $dbJiraConnections->getAllConnectionNamesAndIdsByUid($_SESSION['userid']);
                            for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                if ($projectNames[$i]['id'] === $jiraConnection) {
                                    echo '<option selected value="' . $projectNames[$i]['id'] . '">' . $projectNames[$i]['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $projectNames[$i]['id'] . '">' . $projectNames[$i]['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jiraProject" class="col-sm-4 col-form-label">Projekt</label>
                    <div class="col-sm-8">
                        <select id="jiraProject" name="jiraProject" data-width="100%" data-live-search="true"
                                class="jiraSelect bg-white rounded" data-style="form-control">
                            <?php
                            if (isset($id) && $jiraDBId !== null) {
                                echo '<option value="null" disabled>Auswählen..</option>';
                                include_once '../classes/JiraConnector.php';
                                $jiraConnector = new JiraConnector();
                                $projectNames = $jiraConnector->getProjectsByConnectionId($jiraConnection);
                                for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                    if ($projectNames[$i]->id === $jiraProject) {
                                        echo '<option selected value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->name . '</option>';
                                    } else {
                                        echo '<option value="' . $projectNames[$i]->id . '">' . $projectNames[$i]->name . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="null" disabled selected>Auswählen..</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <select id="jiraTicket" name="jiraTicket" data-width="100%" data-live-search="true"
                                class="bg-white rounded" hidden>
                            <option value='null' disabled selected>Auswählen..</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="jiraTicketName" name="jiraTicketName" value="none">
            </div>
            <div id="redmineOptions" class="col-lg">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"
                           id="redmineSwitch" <?php if ($redmineDBId !== null) echo 'checked="checked"' ?>
                           name="redmineChecked"
                           value="true">
                    <label class="custom-control-label select-pms-label" for="redmineSwitch">Redmine Erfassung</label>
                </div>
                <div class="form-group row">
                    <label for="redmineHost" class="col-sm-4 col-form-label">Verbindung</label>
                    <input type="hidden" name="redmineProjectId" id="redmineProjectId"
                           value="<?php if ($redmineDBId !== null) echo $redmineDBId ?>">
                    <div class="col-sm-8">
                        <select id="redmineHost" name="redmineHost" data-width="100%" data-live-search="true"
                                class="redmineSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Auswählen..</option>
                            <?php
                            $connections = $dbRedmineConnections->getAllConnectionNamesAndIdsByUid($_SESSION['userid']);
                            for ($i = 0, $iMax = count($connections); $i < $iMax; $i++) {
                                if ($connections[$i]['id'] === $redmineConnection) {
                                    echo '<option selected value="' . $connections[$i]['id'] . '">' . $connections[$i]['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $connections[$i]['id'] . '">' . $connections[$i]['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="redmineProject" class="col-sm-4 col-form-label">Projekt</label>
                    <div class="col-sm-8">
                        <select id="redmineProject" name="redmineProject" data-width="100%" data-live-search="true"
                                class="redmineSelect bg-white rounded" data-style="form-control">
                            <?php
                            if (isset($id) && $redmineDBId !== null) {
                                echo '<option value="null" disabled>Auswählen..</option>';
                                include_once '../classes/RedmineConnector.php';
                                $redmineConnector = new RedmineConnector();
                                $projectNames = $redmineConnector->getProjectsByConnectionId($redmineConnection);
                                for ($i = 0, $iMax = count($projectNames['projects']); $i < $iMax; $i++) {
                                    if ($projectNames['projects'][$i]['id'] === $redmineProject) {
                                        echo '<option selected value="' . $projectNames['projects'][$i]['id'] . '">' . $projectNames['projects'][$i]['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $projectNames['projects'][$i]['id'] . '">' . $projectNames['projects'][$i]['name'] . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="null" disabled selected>Auswählen..</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="redmineActivity" class="col-sm-4 col-form-label">Aktivität</label>
                    <div class="col-sm-8">
                        <select id="redmineActivity" name="redmineActivity" data-width="100%" data-live-search="true"
                                class="redmineSelect bg-white rounded" data-style="form-control">
                            <?php
                            if (isset($id) && $redmineDBId !== null) {
                                echo '<option value="null" disabled>Auswählen..</option>';
                                include_once '../classes/RedmineConnector.php';
                                $redmineConnector = new RedmineConnector();
                                $projectNames = $redmineConnector->getActivitiesByConnectionId($redmineConnection);
                                for ($i = 0, $iMax = count($projectNames['time_entry_activities']); $i < $iMax; $i++) {
                                    if ($projectNames['time_entry_activities'][$i]['id'] === $redmineActivity) {
                                        echo '<option selected value="' . $projectNames['time_entry_activities'][$i]['id'] . '">' . $projectNames['time_entry_activities'][$i]['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $projectNames['time_entry_activities'][$i]['id'] . '">' . $projectNames['time_entry_activities'][$i]['name'] . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="null" disabled selected>Auswählen..</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <select id="redmineTicket" name="redmineTicket" data-width="100%" data-live-search="true"
                                class=" bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Auswählen..</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="border-0 p-2 text-center">
                    <?php
                        if ($id != null) {
                            echo '<button type="submit" formaction="../scripts/deleteGlobalProject.php" class="btn btn-outline-danger mr-2">Löchen</button>';
                            echo '<button type="submit" formaction="../scripts/editGlobalProject.php" class="btn btn-outline-secondary mr-2">Editieren</button>';
                        } else {
                            echo '<button type="submit" formaction="../scripts/createGlobalProject.php" class="btn btn-outline-success">Hinzufügen</button>';
                        } ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<script src="../assets/js/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<!-- Other JS for date and timepickers -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

<script src="../vendor/snapappointments/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../vendor/snapappointments/bootstrap-select/dist/js/i18n/defaults-de_DE.min.js"></script>
<script src="../assets/js/global-project-selectpicker.js"></script>
<script src="../assets/js/global-project-selectpicker-global-projects-custom.js"></script>

<script src="../assets/js/disablePMSFormElements.js"></script>
<script src="../assets/js/AJAXJira.js"></script>
<script src="../assets/js/AJAXTroi.js"></script>
<script src="../assets/js/AJAXRedmine.js"></script>
<script src="../assets/js/datepickers.js"></script>
</body>
</html>