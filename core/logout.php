<?php
require 'inc/session.php.inc';
session_destroy();
header('refresh:1;url=../start/index.php');
?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Logout</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Logout</h1>
    <div class="spinner-border" role="status">
        <span class="sr-only">Einen Moment...</span>
    </div>

</div>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<?php include 'inc/bootstrap-js.php.inc' ?>
</body>
</html>