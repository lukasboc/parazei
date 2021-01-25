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
    <title>Datenschutzerklärung</title>
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
            <p style="padding-top: 20px"><a href="index.php" style="text-transform: uppercase">< zurück zum login</a>
            </p>
        </div>
        <div class="col"></div>
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col-md-10">
            <?php include_once '../config/privacy-policy-text.php' ?>
        </div>
        <div class="col"></div>
    </div>
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