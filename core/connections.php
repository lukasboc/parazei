<?php
require 'inc/session.php.inc';

include_once '../classes/DBJiraConnections.php';
$jiraDBConenctions = new DBJiraConnections();
$jiraConnections = $jiraDBConenctions->getAllConnectionsByUid($_SESSION['userid']);

include_once '../classes/DBTroiConnections.php';
$troiDBConenctions = new DBTroiConnections();
$troiConnections = $troiDBConenctions->getAllConnectionsByUid($_SESSION['userid']);

include_once '../classes/DBRedmineConnections.php';
$redmineDBConenctions = new DBRedmineConnections();
$redmineConnections = $redmineDBConenctions->getAllConnectionsByUid($_SESSION['userid']);

?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Verbindungen</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Verbindungen</h1>
    <div class="connectionOverview">
        <h2>Jira Verbindungen</h2>
        <?php if (isset($_SESSION['jiraMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['jiraMsg'] . '</div>';
            unset($_SESSION['jiraMsg']);
        } ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col" class="d-none d-md-table-cell">Host</th>
                <th scope="col" class="d-none d-lg-table-cell">Benutzer</th>
                <th scope="col">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($jiraConnections as $jiraConnection) {
                echo '
                <tr>
                    <td scope="col">' . $jiraConnection['name'] . '</td>
                    <td scope="col" class="d-none d-md-table-cell">' . $jiraConnection['host'] . '</td>
                    <td scope="col" class="d-none d-lg-table-cell">' . $jiraConnection['user'] . '</td>
                    <td scope="col">
                        <form method="post">
                            <input class="form" type="hidden" name="jiraAction" value="edit">
                            <input class="form" type="hidden" name="jiraConnectionId" value="' . $jiraConnection['id'] . '">
                            <button type="submit" formaction="jiraConnection.php" class="btn btn-outline-danger">Editieren</button>
                            <button type="submit" formaction="../scripts/test-jira-connection.php" class="btn btn-outline-success">Testen</button>
                        </form>
                    </td>
                </tr>
                ';
            }
            ?>
            </tbody>
        </table>
        <?php if (count($jiraConnections) === 0) echo '<p class="text-center">Sobald du eine Verbindung erstellt hast, kannst du sie hier sehen!</p>' ?>
        <div class="text-center">
            <form action="jiraConnection.php" method="post">
                <input type="hidden" name="jiraAction" value="new">
                <button type="submit" class="btn btn-success">Neue Jira Verbindung</button>
            </form>
        </div>
    </div>
    <div class="connectionOverview">
        <h2>Troi Verbindungen</h2>
        <?php if (isset($_SESSION['troiMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['troiMsg'] . '</div>';
            unset($_SESSION['troiMsg']);
        } ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col" class="d-none d-md-table-cell">Host</th>
                <th scope="col" class="d-none d-lg-table-cell">Benutzer</th>
                <th scope="col">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($troiConnections as $troiConnection) {
                echo '
                <tr>
                    <td scope="col">' . $troiConnection['name'] . '</td>
                    <td scope="col" class="d-none d-md-table-cell">' . $troiConnection['host'] . '</td>
                    <td scope="col" class="d-none d-lg-table-cell">' . $troiConnection['user'] . '</td>
                    <td scope="col">
                        <form method="post">
                            <input class="form" type="hidden" name="troiAction" value="edit">
                            <input class="form" type="hidden" name="troiConnectionId" value="' . $troiConnection['id'] . '">
                            <button type="submit" formaction="troiConnection.php" class="btn btn-outline-danger">Editieren</button>
                            <button type="submit" formaction="../scripts/test-troi-connection.php" class="btn btn-outline-success">Testen</button>
                        </form>
                    </td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
        <?php if (count($troiConnections) === 0) echo '<p class="text-center">Sobald du eine Verbindung erstellt hast, kannst du sie hier sehen!</p>' ?>
        <div class="text-center">
            <form action="troiConnection.php" method="post">
                <input type="hidden" name="troiAction" value="new">
                <button type="submit" class="btn btn-success">Neue Troi Verbindung</button>
            </form>
        </div>
    </div>
    <div class="connectionOverview">
        <h2>Redmine Verbindungen</h2>
        <?php if (isset($_SESSION['redmineMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['redmineMsg'] . '</div>';
            unset($_SESSION['redmineMsg']);
        } ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col" class="d-none d-md-table-cell">Host</th>
                <th scope="col" class="d-none d-lg-table-cell">Benutzer</th>
                <th scope="col">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($redmineConnections as $redmineConnection) {
                echo '
                <tr>
                    <td scope="col">' . $redmineConnection['name'] . '</td>
                    <td scope="col" class="d-none d-md-table-cell">' . $redmineConnection['host'] . '</td>
                    <td scope="col" class="d-none d-lg-table-cell">' . $redmineConnection['user'] . '</td>
                    <td scope="col">
                        <form method="post">
                            <input class="form" type="hidden" name="redmineAction" value="edit">
                            <input class="form" type="hidden" name="redmineConnectionId" value="' . $redmineConnection['id'] . '">
                            <button type="submit" formaction="redmineConnection.php" class="btn btn-outline-danger">Editieren</button>
                            <button type="submit" formaction="../scripts/test-redmine-connection.php" class="btn btn-outline-success">Testen</button>
                        </form>
                    </td>
                </tr>';
            } ?>
            </tbody>
        </table>
        <?php if (count($redmineConnections) === 0) echo '<p class="text-center">Sobald du eine Verbindung erstellt hast, kannst du sie hier sehen!</p>' ?>
        <div class="text-center">
            <form action="redmineConnection.php" method="post">
                <input type="hidden" name="jiraAction" value="new">
                <button type="submit" class="btn btn-success">Neue Redmine Verbindung</button>
            </form>
        </div>
    </div>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<?php include 'inc/bootstrap-js.php.inc' ?>
</body>
</html>