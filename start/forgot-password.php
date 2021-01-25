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
    <title>Parazei | Passwort vergessen</title>
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
        <div class="col-md-6 border">
            <h2>Passwort vergessen</h2>
            <div class="row">
                <div class="col text-center">
                    <small class="form-text text-muted">Das Passwort bei der Eingabe einer korrekten E-Mail
                        zurückgesetzt. Ein neues Passwort wird generiert und anschließend per Mail zugestellt.
                    </small>
                </div>
            </div>
            <form method="post" action="../scripts/resetPassword.php">
                <div class="form-group">
                    <label for="loginEmail">E-Mail</label>
                    <input type="email" name="email" class="form-control" id="email" required
                           aria-describedby="email">
                </div>
                <div class="row mb-2">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary text-center">Zurücksetzen</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <a href="index.php">Zurück zum Login</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>
    <?php if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'mail-not-found') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Die E-Mail Adresse konnte nicht gefunden werden. Versuche es erneut.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'empty-field') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Bitte fülle das Formular vollständig aus. Versuche es erneut.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'success') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-success">Das Passwort wurde geändert und per Mail verschickt. Gehe zurück zum Login.</div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'success-no-mail') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Das Passwort wurde geändert. Die Mail wurde jedoch nicht verschickt. <strong>Kontaktiere deinen Administrator.</strong></div></div><div class="col"></div></div>';
        }
        if ($_GET['msg'] == 'error') {
            echo '<div class="row mt-2"><div class="col"></div><div class="col-6"><div class="alert alert-danger">Das Passwort wurde <strong>nicht</strong> geändert. Versuche es erneut.</div></div><div class="col"></div></div>';
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