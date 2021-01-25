<?php
require __DIR__ . '/../vendor/autoload.php';
include_once '../classes/DBConnector.php';
$dbConnector = new DBConnector();

use Noodlehaus\Config;
use Defuse\Crypto\Key;

$conf = new Config('../config/db-config.php');

if ($conf->get('mysqlhost') === 'pzb.beispieldomain123.de') {
    echo '<p style="color: red">Bitte konfiguriere die Datenbank in der Datei conf/db-config.php, bevor du das Skript ausführst.</p>';
    die();
}

if ($dbConnector->connect() === null) {
    echo '<p style="color: red">Die Datenbank wurde anscheinend falsch konfiguriert. Bitte prüfe deine Eingaben in conf/db-config.php.</p>';
    die();
}
echo '<h1>Installationsskript</h1>';
echo '-------------------------';
echo '<h2>+++ WICHTIGE INFORMATION +++</h2><p>Es ist möglich, dass es bei der Erstellung der Tabellen und dem setzen der Primärschlüssel zu <strong>fehlerhaften Statusmeldungen</strong> kommt. <br>Wenn die der Erstellung einer Tabelle die Fehlermeldung <strong>"Table ... already exists"</strong> erscheint, kann diese Meldung i.d.R. <strong>ignoriert</strong> werden. <br>Gleiches gilt für die Fehlermeldung <strong>"Multiple primary key defined"</strong> bei dem setzen eines Primärschlüssels.</p>';
echo '------------------------- <br><h2>Statusmeldungen</h2>';
$con = $dbConnector->connect();

$jiAuDaTa = $con->prepare('CREATE TABLE `JiraAuthData` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `apiv3` tinyint(4) NOT NULL
) CHARSET=utf8mb4;');
if ($jiAuDaTa->execute()) {
    echo '<p>JiraAuthData Tabelle erstellt</p>';
} else {
    echo '<p style="color: red">JiraAuthData Tabelle nicht erstellt =>' . $jiAuDaTa->errorInfo()[2] . '</p>';
}
$reAuDaTa = $con->prepare('CREATE TABLE `RedmineAuthData` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` text NOT NULL
) CHARSET=utf8mb4;');
if ($reAuDaTa->execute()) {
    echo '<p>RedmineAuthData Tabelle erstellt</p>';
} else {
    echo '<p style="color: red">RedmineAuthData Tabelle nicht erstellt =>' . $reAuDaTa->errorInfo()[2] . '</p>';
}
$trAuDaTa = $con->prepare('CREATE TABLE `TroiAuthData` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` text NOT NULL
) CHARSET=utf8mb4;');
if ($trAuDaTa->execute()) {
    echo '<p>TroiAuthData Tabelle erstellt</p>';
} else {
    echo '<p style="color: red">TroiAuthData Tabelle nicht erstellt =>' . $trAuDaTa->errorInfo()[2] . '</p>';
}

$usrTa = $con->prepare('CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL
) CHARSET=utf8mb4;');
if ($usrTa->execute()) {
    echo '<p>Users Tabelle erstellt</p>';
} else {
    echo '<p style="color: red">Users Tabelle nicht erstellt =>' . $usrTa->errorInfo()[2] . '</p>';
}

$GlPrTa = $con->prepare('CREATE TABLE `GlobalProjects` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) CHARSET=utf8mb4;');
if ($GlPrTa->execute()) {
    echo '<p>GlobalProjects Tabelle erstellt</p>';
} else {
    echo '<p style="color: red;">GlobalProjects Tabelle nicht erstellt =>' . $GlPrTa->errorInfo()[2] . '</p>';
}

$jiPrTa = $con->prepare('CREATE TABLE `JiraProjects` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `globalProjectsId` int(11) NOT NULL,
  `connectionId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL
) CHARSET=utf8mb4;');
if ($jiPrTa->execute()) {
    echo '<p>JiraProjects Tabelle erstellt</p>';
} else {
    echo '<p style="color: red">JiraProjects Tabelle nicht erstellt =>' . $jiPrTa->errorInfo()[2] . '</p>';
}

$rePrTa = $con->prepare('CREATE TABLE `RedmineProjects` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `globalProjectsId` int(11) NOT NULL,
  `connectionId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `activityId` int(11) NOT NULL
) CHARSET=utf8mb4;');
if ($rePrTa->execute()) {
    echo '<p>RedmineProjects Tabelle erstellt</p>';
} else {
    echo '<p style="color: red">RedmineProjects Tabelle nicht erstellt =>' . $rePrTa->errorInfo()[2] . '</p>';
}

$trPrTa = $con->prepare('CREATE TABLE `TroiProjects` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `globalProjectsId` int(11) NOT NULL,
  `connectionId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `customerId` varchar(255) NOT NULL,
  `projectId` int(11) NOT NULL
) CHARSET=utf8mb4;');
if ($trPrTa->execute()) {
    echo '<p>TroiProjects Tabelle erstellt';
} else {
    echo '<p style="color: red">TroiProjects Tabelle nicht erstellt =>' . $trPrTa->errorInfo()[2] . '</p>';
}

$prKeGlPr = $con->prepare('ALTER TABLE `GlobalProjects`
  ADD PRIMARY KEY (`id`);');
if ($prKeGlPr->execute()) {
    echo '<p>Primärschlüssel für GlobalProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für GlobalProjects `id` nicht gesetzt =>' . $prKeGlPr->errorInfo()[2] . '</p>';
}
$prKeyJiAu = $con->prepare('ALTER TABLE `JiraAuthData`
  ADD PRIMARY KEY (`id`);');
if ($prKeyJiAu->execute()) {
    echo '<p>Primärschlüssel für JiraAuthData `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für JiraAuthData `id` nicht gesetzt =>' . $prKeyJiAu->errorInfo()[2] . '</p>';
}

$prKeyJiPr = $con->prepare('ALTER TABLE `JiraProjects`
  ADD PRIMARY KEY (`id`);');
if ($prKeyJiPr->execute()) {
    echo '<p>Primärschlüssel für JiraProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für JiraProjects `id` nicht gesetzt =>' . $prKeyJiPr->errorInfo()[2] . '</p>';
}

$prKeyReAu = $con->prepare('ALTER TABLE `RedmineAuthData`
  ADD PRIMARY KEY (`id`);');
if ($prKeyReAu->execute()) {
    echo '<p>Primärschlüssel für RedmineAuthData `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für RedmineAuthData `id` nicht gesetzt =>' . $prKeyReAu->errorInfo()[2] . '</p>';
}

$prKeyRePr = $con->prepare('ALTER TABLE `RedmineProjects`
  ADD PRIMARY KEY (`id`);');
if ($prKeyRePr->execute()) {
    echo '<p>Primärschlüssel für RedmineProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für RedmineProjects `id` nicht gesetzt =>' . $prKeyRePr->errorInfo()[2] . '</p>';
}

$prKeyTrAu = $con->prepare('ALTER TABLE `TroiAuthData`
  ADD PRIMARY KEY (`id`);');
if ($prKeyTrAu->execute()) {
    echo '<p>Primärschlüssel für TroiAuthData `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für TroiAuthData `id` nicht gesetzt =>' . $prKeyTrAu->errorInfo()[2] . '</p>';
}

$prKeyTrPr = $con->prepare('ALTER TABLE `TroiProjects`
  ADD PRIMARY KEY (`id`);');
if ($prKeyTrPr->execute()) {
    echo '<p>Primärschlüssel für TroiProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für TroiProjects `id` nicht gesetzt =>' . $prKeyTrPr->errorInfo()[2] . '</p>';
}

$prKeyUsr = $con->prepare('ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);');
if ($prKeyUsr->execute()) {
    echo '<p>Primärschlüssel für Users `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Primärschlüssel für Users `id` nicht gesetzt =>' . $prKeyUsr->errorInfo()[2] . '</p>';
}

$auIncGlPro = $con->prepare('ALTER TABLE `GlobalProjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncGlPro->execute()) {
    echo '<p>Auto_Increment für GlobalProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für GlobalProjects `id` nicht gesetzt =>' . $auIncGlPro->errorInfo()[2] . '</p>';
}

$auIncJiAu = $con->prepare('ALTER TABLE `JiraAuthData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncJiAu->execute()) {
    echo '<p>Auto_Increment für JiraAuthData `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für JiraAuthData `id` nicht gesetzt =>' . $auIncJiAu->errorInfo()[2] . '</p>';
}

$auIncJiPr = $con->prepare('ALTER TABLE `JiraProjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncJiPr->execute()) {
    echo '<p>Auto_Increment für JiraProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für JiraProjects `id` nicht gesetzt =>' . $auIncJiPr->errorInfo()[2] . '</p>';
}

$auIncReAu = $con->prepare('ALTER TABLE `RedmineAuthData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncReAu->execute()) {
    echo '<p>Auto_Increment für RedmineAuthData `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für RedmineAuthData `id` nicht gesetzt =>' . $auIncReAu->errorInfo()[2] . '</p>';
}

$auIncRePr = $con->prepare('ALTER TABLE `RedmineProjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncRePr->execute()) {
    echo '<p>Auto_Increment für RedmineProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für RedmineProjects `id` nicht gesetzt =>' . $auIncRePr->errorInfo()[2] . '</p>';
}

$auIncTrAu = $con->prepare('ALTER TABLE `TroiAuthData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncTrAu->execute()) {
    echo '<p>Auto_Increment für TroiAuthData gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für TroiAuthData `id` nicht gesetzt =>' . $auIncTrAu->errorInfo()[2] . '</p>';
}

$auIncTrPr = $con->prepare('ALTER TABLE `TroiProjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncTrPr->execute()) {
    echo '<p>Auto_Increment für TroiProjects `id` gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für TroiProjects `id` nicht gesetzt =>' . $auIncTrPr->errorInfo()[2] . '</p>';
}

$auIncUsr = $con->prepare('ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;');
if ($auIncUsr->execute()) {
    echo '<p>Auto_Increment für Users `id`gesetzt.</p>';
} else {
    echo '<p style="color: red">Auto_Increment für Users `id` nicht gesetzt =>' . $auIncUsr->errorInfo()[2] . '</p>';
}

if (!file_exists('encryption-key.txt')) {
    $file = 'encryption-key.txt';
    $key = Key::createNewRandomKey();
    $asciiSafeKey = $key->saveToAsciiSafeString();
    if (!file_put_contents($file, $asciiSafeKey)) {
        echo '<p style="color: red">Eine Datei mit einem Schlüssel zur Verschlüsselung der Nutzerdaten wurde <strong>nicht</strong> erstellt. Bitte erstelle manuell einen Schlüssel.</p>';
    } else {
        echo '<p>Eine Datei mit einem Schlüssel zur Verschlüsselung der Nutzerdaten wurde erstellt.</p>';
        chmod($file, 0600);
    }
} else {
    echo '<p style="color: red">Eine Datei mit einem Schlüssel zur Verschlüsselung der Nutzerdaten existiert bereits. Eine neue Datei wurde nicht erstellt.</p>';
}
echo '------------------------- <br><h2>Abschlussworte</h2>';
echo '<p>Einrichtung abgeschlossen. Teste, ob eine Registrierung möglich ist und lösche unbedingt diese Datei, sofern alles funktioniert.</p><p style="color: darkred; font-weight: bold">Bitte lösche diese Datei, wenn alles ordnungsgemäß funktioniert.</p>';