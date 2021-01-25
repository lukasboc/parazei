<?php
require 'inc/session.php.inc';

$redmineAction = $_POST['redmineAction'] ?? null;

$id = null;
$name = null;
$host = null;
$username = null;
$password = null;
$apiVThree = null;

if (isset($_POST['redmineConnectionId']) || isset($_SESSION['redmineConnectionId'])) {
    if (isset($_POST['redmineConnectionId'])) {
        $id = $_POST['redmineConnectionId'];
    }
    if (isset($_SESSION['redmineConnectionId'])) {
        $id = $_SESSION['redmineConnectionId'];
        unset($_SESSION['redmineConnectionId']);
    }
    include_once '../classes/DBRedmineConnections.php';
    $redmineDBConenctions = new DBRedmineConnections();
    $redmineConnection = $redmineDBConenctions->getConnectionById($id, $_SESSION['userid']);
    if ($redmineConnection[0]['id'] == null) {
        $_SESSION['redmineMsg'] = 'Netter Versuch.';
        header('Location: ../core/connections.php');
        die();
    }
    $name = $redmineConnection[0]['name'];
    $host = $redmineConnection[0]['host'];
    $username = $redmineConnection[0]['user'];
    $password = $redmineConnection[0]['password'];
}
?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Redmine Verbindung</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Redmine Verbindung</h1>
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
            <label for="password" class="col-sm-2 col-form-label">Passwort</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password"
                       value="<?php if ($password !== null) echo $password ?>">
                <small>Deine Anmeldedaten werden verschlüsselt gespeichert.</small>
            </div>
        </div>

        <div class="form-group row text-center">
            <div class="col">
                <?php
                if ($id != null) {
                    echo '<button type="submit" formaction="../scripts/deleteRedmineConnection.php" class="btn btn-outline-danger mr-2">Löchen</button>';
                    echo '<button type="submit" formaction="../scripts/editRedmineConnection.php" class="btn btn-outline-secondary mr-2">Editieren</button>';
                } else {
                    echo '<button type="submit" formaction="../scripts/createRedmineConnection.php" class="btn btn-outline-success">Hinzufügen</button>';
                }
                if (isset($_SESSION['redmineMsg'])) {
                    echo '<p class="text-center">' . $_SESSION['redmineMsg'] . '</p>';
                    unset($_SESSION['redmineMsg']);
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