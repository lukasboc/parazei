<?php
require 'inc/session.php.inc';
include_once '../classes/DBUsers.php';

$dbUsers = new DBUsers();
$currentMail = $dbUsers->getMailByUserId($_SESSION['userid']);
?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Einstellungen</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Einstellungen</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 bg-light p-2">
                <h2>E-Mail ändern</h2>
                <form action="../scripts/changeMail.php" method="post">
                    <div class="form-group">
                        <label for="oldMail">Alte E-Mail</label>
                        <input type="email" class="form-control" id="oldMail" value="<?php echo $currentMail ?>"
                               disabled aria-describedby="oldMail">
                    </div>
                    <div class="form-group">
                        <label for="newMail">Neue E-Mail</label>
                        <input type="email" name="newMail" class="form-control" id="newMail">
                    </div>
                    <div class="form-group">
                        <label for="password">Passwort</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Speichern</button>
                        <?php if (isset($_SESSION['mailMsg'])) {
                            echo '<p>' . $_SESSION['mailMsg'] . '</p>';
                            unset($_SESSION['mailMsg']);
                        } ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="card border-0 bg-light p-2">
                <h2>Passwort ändern</h2>
                <form action="../scripts/changePassword.php" method="post">
                    <div class="form-group">
                        <label for="currentPassword">Altes Passwort</label>
                        <input type="password" name="currentPassword" class="form-control" id="currentPassword"
                               aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="newPasswordTwo">Neues Passwort</label>
                        <input type="password" name="newPasswordOne" class="form-control" id="newPasswordOne">
                    </div>
                    <div class="form-group">
                        <label for="newPasswordTwo">Neues Passwort wiederholen</label>
                        <input type="password" name="newPasswordTwo" class="form-control" id="newPasswordTwo">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Speichern</button>
                        <?php if (isset($_SESSION['msg'])) {
                            echo '<p>' . $_SESSION['msg'] . '</p>';
                            unset($_SESSION['msg']);
                        } ?>
                        <?php if (isset($_SESSION['ErrMsg'])) {
                            echo '<p>' . $_SESSION['ErrMsg'] . '</p>';
                            unset($_SESSION['ErrMsg']);
                        } ?>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<?php include 'inc/bootstrap-js.php.inc' ?>
</body>
</html>