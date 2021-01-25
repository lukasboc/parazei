<?php
require 'inc/session.php.inc';
include_once '../classes/DBTroiConnections.php';
$troiDBConenctions = new DBTroiConnections();

$troiAction = $_POST['troiAction'] ?? null;

$id = null;
$name = null;
$host = null;
$username = null;
$password = null;
$apiVThree = null;

if (isset($_POST['troiConnectionId']) || isset($_SESSION['troiConnectionId'])) {
    if (isset($_POST['troiConnectionId'])) {
        $id = $_POST['troiConnectionId'];
    }
    if (isset($_SESSION['troiConnectionId'])) {
        $id = $_SESSION['troiConnectionId'];
        unset($_SESSION['troiConnectionId']);
    }
    $troiConnection = $troiDBConenctions->getConnectionById($id, $_SESSION['userid']);
    if ($troiConnection[0]['id'] == null) {
        $_SESSION['troiMsg'] = 'Netter Versuch.';
        header('Location: ../core/connections.php');
        die();
    }
    $name = $troiConnection[0]['name'];
    $host = $troiConnection[0]['host'];
    $username = $troiConnection[0]['user'];
    $password = $troiConnection[0]['password'];
}
?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Troi Verbindung</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Troi Verbindung</h1>
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
                    echo '<button type="submit" formaction="../scripts/deleteTroiConnection.php" class="btn btn-outline-danger mr-2">Löchen</button>';
                    echo '<button type="submit" formaction="../scripts/editTroiConnection.php" class="btn btn-outline-secondary mr-2">Editieren</button>';
                } else {
                    echo '<button type="submit" formaction="../scripts/createTroiConnection.php" class="btn btn-outline-success">Hinzufügen</button>';
                }
                if (isset($_SESSION['troiMsg'])) {
                    echo '<p class="text-center">' . $_SESSION['troiMsg'] . '</p>';
                    unset($_SESSION['troiMsg']);
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