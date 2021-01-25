<?php
require 'inc/session.php.inc';

$jiraAction = $_POST['jiraAction'] ?? null;

$id = null;
$name = null;
$host = null;
$username = null;
$password = null;
$apiVThree = null;

if (isset($_POST['jiraConnectionId']) || isset($_SESSION['jiraConnectionId'])) {
    if (isset($_POST['jiraConnectionId'])) {
        $id = $_POST['jiraConnectionId'];
    }
    if (isset($_SESSION['jiraConnectionId'])) {
        $id = $_SESSION['jiraConnectionId'];
        unset($_SESSION['jiraConnectionId']);
    }
    include_once '../classes/DBJiraConnections.php';
    $jiraDBConenctions = new DBJiraConnections();
    $jiraConnection = $jiraDBConenctions->getConnectionById($id, $_SESSION['userid']);
    if ($jiraConnection[0]['id'] == null) {
        $_SESSION['jiraMsg'] = 'Netter Versuch.';
        header('Location: ../core/connections.php');
        die();
    }
    $name = $jiraConnection[0]['name'];
    $host = $jiraConnection[0]['host'];
    $username = $jiraConnection[0]['user'];
    $password = $jiraConnection[0]['password'];
    $apiVThree = $jiraConnection[0]['apiv3'];
}
?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Jira Verbindung</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Jira Verbindung</h1>
    <form method="post">
        <input type="hidden" id="id" name="id" value="<?php if ($id !== null) echo $id ?>">
        <div class="form-group row">
            <label for="connectionName" class="col-sm-2 col-form-label">Verbindungsname</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="connectionName" name="connectionName"
                       value="<?php if ($name !== null) echo $name ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="host" class="col-sm-2 col-form-label">Host</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="host" name="host"
                       value="<?php if ($host !== null) echo $host ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label">Benutzername</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username"
                       value="<?php if ($username !== null) echo $username ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">API Token<br>
                <small>(Passwort bei APIv2)</small>
            </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password"
                       value="<?php if ($password !== null) echo $password ?>">
                <small>Deine Anmeldedaten werden verschlüsselt gespeichert.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="apivthree" class="col-sm-2 col-form-label">API v3<br>
                <small>(Empfohlen)</small>
            </label>
            <div class="col-sm-10">
                <input type="checkbox" class="form-control" id="apivthree" name="apivthree" value="true"
                    <?php if ($apiVThree === '1') {
                        echo 'checked';
                    } ?>>
            </div>
        </div>

        <div class="form-group row text-center">
            <div class="col">
                <?php
                if ($id != null) {
                    echo '<button type="submit" formaction="../scripts/deleteJiraConnection.php" class="btn btn-outline-danger mr-2">Löchen</button>';
                    echo '<button type="submit" formaction="../scripts/editJiraConnection.php" class="btn btn-outline-secondary mr-2">Editieren</button>';
                } else {
                    echo '<button type="submit" formaction="../scripts/createJiraConnection.php" class="btn btn-outline-success">Hinzufügen</button>';
                }
                if (isset($_SESSION['jiraMsg'])) {
                    echo '<p class="text-center">' . $_SESSION['jiraMsg'] . '</p>';
                    unset($_SESSION['jiraMsg']);
                }
                ?>
            </div>
        </div>
    </form>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<?php include 'inc/bootstrap-js.php.inc' ?>
</body>
</html>