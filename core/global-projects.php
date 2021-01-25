<?php
require 'inc/session.php.inc';

include_once '../classes/DBGlobalProjects.php';
$dbGlobalProjects = new DBGlobalProjects();
$dbGlobalProjects = $dbGlobalProjects->getAllGlobalProjectsByUserID($_SESSION['userid']);

?>
<!doctype html>
<html lang="de">
<head>
    <?php include 'inc/head-entries.php.inc' ?>
    <title>Parazei | Globale Projekte</title>
</head>
<?php include 'inc/nav.php.inc' ?>
<body>
<div class="container page-content-container-core">
    <h1 class="my-4">Globale Projekte</h1>
    <div class="text-center pb-3">
        <form action="global-project.php" method="post">
            <button type="submit" class="btn btn-success">Neues Projekt</button>
        </form>
    </div>
    <div class="projectOverview">
        <?php if (isset($_SESSION['projectsMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['projectsMsg'] . '</div>';
            unset($_SESSION['projectsMsg']);
        } ?>
        <?php if (isset($_SESSION['jiraErrMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['jiraErrMsg'] . '</div>';
            unset($_SESSION['jiraErrMsg']);
        } ?>
        <?php if (isset($_SESSION['redmineErrMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['redmineErrMsg'] . '</div>';
            unset($_SESSION['redmineErrMsg']);
        } ?>
        <?php if (isset($_SESSION['troiErrMsg'])) {
            echo '<div class="alert alert-info">' . $_SESSION['troiErrMsg'] . '</div>';
            unset($_SESSION['troiErrMsg']);
        } ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Aktion</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($dbGlobalProjects as $dbGlobalProject) {
                echo '
                <tr>
                    <td scope="col">' . $dbGlobalProject['name'] . '</td>
                    <td scope="col">
                        <form action="global-project.php" method="post">
                            <input class="form" type="hidden" name="projectAction" value="edit">
                            <input class="form" type="hidden" name="globalProjectId" value="' . $dbGlobalProject['id'] . '">
                            <button type="submit" class="btn btn-outline-danger">Editieren</button>
                        </form>
                    </td>
                </tr>
                ';
            }
            ?>
            </tbody>
        </table>
        <?php if (count($dbGlobalProjects) === 0) echo '<p class="text-center">Sobald du eine Verbindung erstellt hast, kannst du sie hier sehen!</p>' ?>
    </div>
</div>
<?php include_once 'inc/footer.php.inc' ?>
<?php include 'inc/bootstrap-js.php.inc' ?>
</body>
</html>