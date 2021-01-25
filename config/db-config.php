<?php

// localhost oder Domain fuer externen Zugriff
// Beispiel: $config['mysqlhost'] = 'pzb.beispieldomain123.de';
$config['mysqlhost'] = 'pzb.beispieldomain123.de';

// Name der MySQL Datenbank
// Beispiel: $config['mysqldbname'] = 'datenbankname123';
$config['mysqldbname'] = 'datenbankname123';

// Datenbankbenutzer
// Beispiel: $config['mysqluser'] = 'nutzername123';
$config['mysqluser'] = 'nutzername123';

// Passwort des Datenbankbenutzers
// Beispiel: $config['mysqlpassword'] = 'passwort123';
$config['mysqlpassword'] = 'passwort123';


// Schlüssel, um DB Informationen zu entschlüsseln.
// NACH DER ERSTEN REGISTRIERUNG NICHT MEHR ÄNDERN
// Generator für Schlüssel: https://www.random.org/strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=html
$config['dbEncryptionKey'] = 'CKjHGELaTm4Mbv5UvkiG';

return $config;