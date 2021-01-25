<?php
require 'inc/session.php.inc';
include_once '../classes/DBTroiConnections.php';
include_once '../classes/DBJiraConnections.php';
include_once '../classes/DBRedmineConnections.php';
include_once '../classes/DBGlobalProjects.php';
require __DIR__ . '/../vendor/autoload.php';


$dbTroiConnections = new DBTroiConnections();
$dbJiraConnections = new DBJiraConnections();
$dbRedmineConnections = new DBRedmineConnections();
$dbGlobalProjects = new DBGlobalProjects();

$globalProjects = $dbGlobalProjects->getAllGlobalProjectsByUserID($_SESSION['userid']);
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
    <title>Parazei | Zeit buchen</title>
</head>
<?php include 'inc/nav.php.inc'?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Zeit buchen</h1>
    <?php if (isset($_SESSION['worklogMsg'])) {
        echo '<div class="alert alert-warning">' . $_SESSION['worklogMsg'] . '</div>';
        unset($_SESSION['worklogMsg']);
    } ?>
    <?php if (isset($_SESSION['worklogTroiMsg'])) {
        echo '<div class="alert alert-info">' . $_SESSION['worklogTroiMsg'] . '</div>';
        unset($_SESSION['worklogTroiMsg']);
    } ?>
    <?php if (isset($_SESSION['worklogJiraMsg'])) {
        echo '<div class="alert alert-info">' . $_SESSION['worklogJiraMsg'] . '</div>';
        unset($_SESSION['worklogJiraMsg']);
    } ?>
    <?php if (isset($_SESSION['worklogRedmineMsg'])) {
        echo '<div class="alert alert-info">' . $_SESSION['worklogRedmineMsg'] . '</div>';
        unset($_SESSION['worklogRedmineMsg']);
    } ?>
    <form action="../scripts/createWorklogs.php" method="post">
        <div class="form-group row">
            <label for="date" class="col-sm-3 col-form-label">Datum</label>
            <div class="col-sm-9">
                <div class="input-group date" id="worklogDate" data-target-input="nearest">
                    <input type="text" required name="worklogDate" id="date" class="form-control datetimepicker-input"
                           data-target="#worklogDate"/>
                    <div class="input-group-append" data-target="#worklogDate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="duration" class="col-sm-3 col-form-label">Dauer</label>
            <div class="col-sm-9">
                <div class="input-group date" id="worklogDuration" data-target-input="nearest">
                    <input type="text" required name="worklogDuration" id="duration"
                           class="form-control datetimepicker-input" data-target="#worklogDuration"/>
                    <div class="input-group-append" data-target="#worklogDuration" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="note" class="col-sm-3 col-form-label">Notiz</label>
            <div class="col-sm-9">
                <input type="text" required name="worklogNote" class="form-control" id="note">
            </div>
        </div>
        <div class="form-group row">
            <label for="globalProjectsSelect" class="col-sm-3 col-form-label">Globales
                Projekt<br><small>(optional)</small></label>
            <div class="col-sm-9">
                <select id="globalProjectsSelect" data-width="100%" data-live-search="true" data-style="form-control">
                    <option selected>Kein globales Projekt</option>
                    <option data-divider="true"></option>
                    <?php
                    if ($globalProjects !== null) {
                        foreach ($globalProjects as $globalProject) {
                            echo '<option value="' . $globalProject['id'] . '">' . $globalProject['name'] . '</option>';
                        }
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row mt-5">
            <div id="troiOptions" class="col-lg">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="troiSwitch" name="troiChecked" value="true">
                    <label class="custom-control-label select-pms-label" for="troiSwitch">Troi Erfassung</label>
                </div>

                <div class="form-group row">
                    <label for="troiHost" class="col-sm-4 col-form-label">Verbindung</label>
                    <div class="col-sm-8">
                        <select id="troiHost" name="troiHost" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                            <?php
                            $projectNames = $dbTroiConnections->getAllConnectionNamesAndIdsByUid($_SESSION['userid']);

                            for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                echo '<option value="' . $projectNames[$i]['id'] . '">' . $projectNames[$i]['name'] . '</option>';

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
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <span class="col-10 border-bottom text-center mb-3 text-secondary">Optional</span>
                    <div class="col"></div>
                </div>
                <div class="form-group row">
                    <label for="troiCustomer" class="col-sm-4 col-form-label">Kunde</label>
                    <div class="col-sm-8">
                        <select id="troiCustomer" name="troiCustomer" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="troiProject" class="col-sm-4 col-form-label">Projekt</label>
                    <div class="col-sm-8">
                        <select id="troiProject" name="troiProject" data-width="100%" data-live-search="true"
                                class="troiSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <span class="col-10 border-bottom text-center mb-3 text-secondary"></span>
                    <div class="col"></div>
                </div>
                <div class="form-group row">
                    <label for="troiBillingPosition" class="col-sm-4 col-form-label">Kalkulations-position</label>
                    <div class="col-sm-8">
                        <select id="troiBillingPosition" name="troiBillingPosition" data-width="100%"
                                data-live-search="true" class="troiSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="troiPrefix" class="col-sm-7 col-form-label">Ticket Nr. als Präfix</label>
                    <div class="col-sm-5">
                        <input type="checkbox" class="form-check-input" name="troiPrefix" id="troiPrefix" value="true">
                    </div>
                </div>
            </div>
            <div id="jiraOptions" class="col-lg">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="jiraSwitch" name="jiraChecked" value="true">
                    <label class="custom-control-label select-pms-label" for="jiraSwitch">Jira Erfassung</label>
                </div>
                <div class="form-group row">
                    <label for="jiraHost" class="col-sm-4 col-form-label">Verbindung</label>
                    <div class="col-sm-8">
                        <select id="jiraHost" name="jiraHost" data-width="100%" data-live-search="true"
                                class="jiraSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                            <?php
                            $projectNames = $dbJiraConnections->getAllConnectionNamesAndIdsByUid($_SESSION['userid']);
                            for ($i = 0, $iMax = count($projectNames); $i < $iMax; $i++) {
                                echo '<option value="' . $projectNames[$i]['id'] . '">' . $projectNames[$i]['name'] . '</option>';

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
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jiraTicket" class="col-sm-4 col-form-label">Ticket</label>
                    <div class="col-sm-8">
                        <select id="jiraTicket" name="jiraTicket" data-width="100%" data-live-search="true"
                                class="jiraSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="jiraTicketName" name="jiraTicketName" value="none">
            </div>
            <div id="redmineOptions" class="col-lg">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="redmineSwitch" name="redmineChecked"
                           value="true">
                    <label class="custom-control-label select-pms-label" for="redmineSwitch">Redmine Erfassung</label>
                </div>
                <div class="form-group row">
                    <label for="redmineHost" class="col-sm-4 col-form-label">Verbindung</label>
                    <div class="col-sm-8">
                        <select id="redmineHost" name="redmineHost" data-width="100%" data-live-search="true"
                                class="redmineSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                            <?php
                            $connections = $dbRedmineConnections->getAllConnectionNamesAndIdsByUid($_SESSION['userid']);
                            for ($i = 0, $iMax = count($connections); $i < $iMax; $i++) {
                                echo '<option value="' . $connections[$i]['id'] . '">' . $connections[$i]['name'] . '</option>';

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
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="redmineActivity" class="col-sm-4 col-form-label">Aktivität</label>
                    <div class="col-sm-8">
                        <select id="redmineActivity" name="redmineActivity" data-width="100%" data-live-search="true"
                                class="redmineSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="redmineTicket" class="col-sm-4 col-form-label">Ticket<br>
                        <small>(optional)</small>
                    </label>
                    <div class="col-sm-8">
                        <select id="redmineTicket" name="redmineTicket" data-width="100%" data-live-search="true"
                                class="redmineSelect bg-white rounded" data-style="form-control">
                            <option value='null' disabled selected>Bitte wählen...</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row text-center">
            <div class="col">
                <button type="submit" class="btn btn-primary">Buchen</button>
            </div>
        </div>
    </form>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<!-- Script -->

<!-- jQuery first, then Popper.js, then Bootstrap JS. different JQ because AJAX -->
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

<!-- Global Project Picker -->
<script src="../vendor/snapappointments/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../vendor/snapappointments/bootstrap-select/dist/js/i18n/defaults-de_DE.min.js"></script>
<script src="../assets/js/global-project-selectpicker.js"></script>

<script src="../assets/js/disablePMSFormElements.js"></script>
<script src="../assets/js/AJAXJira.js"></script>
<script src="../assets/js/AJAXTroi.js"></script>
<script src="../assets/js/AJAXRedmine.js"></script>
<script src="../assets/js/datepickers.js"></script>

<script src="../assets/js/AJAXglobalProjects.js"></script>

</body>
</html>