<?php

//Sind neue Registrierungen erlaubt?
//Gültige Eingaben: 'true', 'false'
$config['allowRegistrations'] = 'true';

//Welcher Name soll im Login-Bereich angezeigt werden?
//Default: none | Alle Strings erlaubt
$config['companyName'] = 'none';

//Logging-Level der Datenbank
//Gültige Werte: 'DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'
//Default: WARNING | Mehr Informationen zu den Werten unter: https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md#log-levels
$config['dbLogging'] = 'DEBUG';

return $config;