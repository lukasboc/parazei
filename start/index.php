<?php
require __DIR__ . '/../vendor/autoload.php';

use Noodlehaus\Config;

$conf = new Config('../config/general-config.php');

?>
<html lang="de">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Parazei | Login</title>
</head>
<body>
<div class="container pt-5 page-content-container">
    <div class="row">
        <div class="col"></div>
        <div class="col-md-6 text-center pb-4">
            <img src="../assets/img/parazei-medium.png" width="90%" alt="Parazei - Parallele Zeiterfassung">

            <?php if ($conf->get('companyName') != 'none') {
                echo '
                <h4 class="text-right font-italic"><small class="font-weight-lighter">// ' . $conf->get('companyName') . '</small><h4>
                ';
            } ?>
        </div>
        <div class="col"></div>
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col-md-6 border border">
            <h3>Einloggen</h3>
            <form action="../scripts/login.php" method="post">
                <div class="form-group">
                    <label for="loginEmail">E-Mail</label>
                    <input type="email" name="email" class="form-control" id="loginEmail" required
                           aria-describedby="email">
                </div>
                <div class="form-group">
                    <label for="loginPassword">Passwort</label>
                    <input type="password" name="password" class="form-control" required id="loginPassword">
                </div>
                <button type="submit" class="btn btn-primary">Einloggen</button>
            </form>
            <a href="forgot-password.php">Passwort vergessen?</a>
        </div>
        <div class="col"></div>
    </div>
    <?php if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'empty-input') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Bitte fülle alle Felder aus.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'could-not-login') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Anmeldung nicht erfolgreich. Versuche es erneut.</div></div><div class="col"></div></div>';
        }
    } ?>
    <?php
    if ($conf->get('allowRegistrations') === 'true') {
        echo '
        <div class="row mt-3">
        <div class="col"></div>
        <div class="col-md-6 border">
            <h3>Registrieren</h3>
            <form action="../scripts/register.php" method="post">
                <div class="form-group">
                    <label for="registerEmail">E-Mail</label>
                    <input type="email" name="email" required class="form-control" id="registerEmail"
                           aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="registerPasswordOne">Passwort</label>
                    <input type="password" name="passwordOne" required class="form-control" id="registerPasswordOne">
                    <small>> 7 Zeichen | Mindestens ein Buchstabe und eine Zahl</small>
                </div>
                <div class="form-group">
                    <label for="registerPasswordTwo">Passwort wiederholung</label>
                    <input type="password" name="passwordTwo" class="form-control" required id="registerPasswordTwo">
                </div>
                <button type="submit" class="btn btn-primary">Registrieren</button>
                
            </form>
        </div>
        <div class="col"></div>
    </div>';
    } ?>
    <?php if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'error-requirements') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Deine Eingaben erfüllten nicht die Anforderungen. Versuche es erneut.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'error-valid-email') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Bitte gib eine gültige E-Mail Adresse ein. Versuche es erneut.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'registration-successfull') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-success">Registierung erfolgreich. Eine Bestätigungsmail ist unterwegs. Du kannst dich nun anmelden.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'registration-successfull-no-mail') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-info">Registierung erfolgreich. Die Bestätigungsmail konnte jedoch nicht zugestellt werden. Du kannst dich nun anmelden.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'registration-error') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Registierung nicht erfolgreich. Versuche es erneut ggf. mit anderen Eingaben.</div></div><div class="col"></div></div>';
        }
    } ?>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>