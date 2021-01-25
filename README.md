# Parallele Zeitbuchung
Dieses Tool ist in der Lage, Arbeitszeit parallel in Jira, Troi und Redmine zu buchen. Es reduziert die manuellen Eingaben bei der Buchung von Arbeitszeit in mehrere Systeme um die doppelte Eingabe von Datum, Startzeit, Endzeit und Notiz.
## Installation
Zur Installation müssen sämtliche Dateien auf einem Webserver platziert werden. Nachdem die Dateien erfolgreich übertragen wurden, müssen Konfigurationen vorgenommen werden und anschließend ein Installationsskript ausgeführt werden. 

Hinweis: Per Default ist kein **Verzeichnisschutz** eingestellt. Die Absicherung der Installation muss vom Administrator, z.B. durch die Verwendung von .htaccess-Dateien, selber durchgeführt werden.
### Datenbank Konfiguration
Die Datenbank-Konfiguration muss in der config/db-config.php vorgenommen werden. Die Werte werden als Strings benötigt, weshalb alle Werte in Anführungszeichen eingetragen werden müssen.

Eingaben werden wie folgt benötigt:


    $config['mysqlhost'] = 'sub.domain.tld'
    $config['mysqldbname'] = 'datenbankname';
    $config['mysqluser'] = 'nutzername';
    $config['mysqlpassword'] = 'passwort';
    $config['dbEncryptionKey'] = 'ZufaelligeZeichenfolge';
    
Die Konfiguration 'dbEncryptionKey' ist für das Hashing-Verfahren der Passwörter notwendig.

### Weitere Konfigurationen
Neben der Datenbank können in der config/general-config.php weitere Konfigurationen vorgenommen werden. Auch hier werden die Werte als Strings benötigt.

Über den folgenden Wert können neue Registrierungen verhindert werden. Erlaubte Werte sind 'true' und 'false'.

    $config['allowRegistrations'] = 'true';
    
Wenn der Folgende Wert verändert wird, wird auf der Startseite (Loginseite) der eingegebene Name ausgegeben. Erlaubt sind alle Strings.

    $config['companyName'] = 'none';

Um das Logging Level des Systems zu verändern, kann folgende Konfiguration geändert werden. 

        $config['dbLogging'] = 'WARNING';
        
Gültige Werte sind 'DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'. Exceptions werden ab dem Logging-Level 'ERROR' in Logs geschrieben. Sofern die Datenbankanweisung nicht ausgeführt werden kann, wird dies ab dem Level 'WARNUING' erfasst. Um alle Aktionen der Datenbank lesen zu können, kann das Logging-Level auf 'DEBUG' gesetzt werden.

### Impressum- und Datenschutztexte
Um die Anwendung ordnungsgemäß betreiben zu dürfen sind unter anderem Texte für Impressum und Datenschutz nötig. Diese können im config Ordner angepasst werden. Zum Bearbeiten des Impressum-Textes muss die Datei *config/imprint-text.php* angepasst werden. Für die Datenschutzerklärung analog die Datei *config/privacy-policy-text.php*. 

### Ausführung des Installationsskripts
**ERST NACH DER KONFIGURATION DER DATENBANK AUSFÜHREN!**

Um das Installationsskript auszuführen, muss es im Browser wie folgt aufgerufen werden:

    http(s)://beispielseite.tld/config/install.php
Das Skript erstellt in der vorher konfigurierten Datenbank alle benötigten Tabellen. Nachdem das Skript erfolgreich wurde, **muss die Datei gelöscht** werden. Sollte das Skript fehlschlagen, müssen die Tabellen ggf. manuell angelegt werden. Die benötigten Tabellen und Spalten sind dem Installationsskript zu entnehmen.

Sichern Sie unbedingt die Datei *config/encryption-key.txt* vor externen Zugriffen ab.
## Nutzung
Um Buchungen vornehmen zu könne, müssen zuerst Verbindungen hinzugefügt werden. Eine Verbindung besteht aus einem Host, Anmeldeinformation für die REST APIs der Systeme und ggf. weiteren Informationen. Bei der Eingabe des Hosts ist die Form zu beachten.

Gültige Eingaben für den Host:

    https://sub.domain.tld
    http://sub.domain.tld
    https://domain.tld
    http://domain.tld
    
Ungültige Eingaben:

    www.sub.domain.tld
    www.domain.tld
    https://domain.tld/
    http://domain.tld/
    domain.tld
    sub.domain.tld


### Troi Verbindungen
Eine Troi Verbindung besteht aus einem Host, einem Nutzernamen und einem Passwort.
### Jira Verbindungen
Eine Jira Verbindung besteht aus einem Host, einem Nutzernamen, einem API Token und der Information, ob die REST API der Jira Instanz in der Version 3 vorhanden ist. Wenn es sich um eine Jira Cloud Instanz handelt, muss der Wert auf true gesetzt werden. Eine Anleitung zur generierung eines gültigen API Tokens ist hier zu finden: https://confluence.atlassian.com/cloud/api-tokens-938839638.html
### Redmine Verbindungen
Eine Troi Verbindung besteht aus einem Host, einem Nutzernamen und einem Passwort.
### Buchungen
Um eine Buchung vorzunehmen, müssen ein Datum, eine Startzeit, eine Endzeit und eine Notiz eingetragen werden. Im unteren Teil des Formular können die vorher erstellten Verbindungen ausgewählt werden, nachdem die Checkboxes für die gewünschten Verbindungsarten gewählt wurden.
#### Troi
Um eine Buchung in Troi vorzunehmen, muss als erstes der gewünschte Mandant ausgewählt werden (i.d.R. der Firmenname). Nach der Auswahl des Mandanten, kann bereits eine Kalkulationsposition ausgewählt werden. Um die Auswahl einzuschränken, kann vor der Wahl der Kalkulationsposition ein Kunde und ein Projekt ausgewählt werden. Ein Projekt kann jedoch nur ausgewählt werden, wenn bereits ein Kunde ausgewählt wurde.

Wenn gewünscht, kann der Name des Tickets, auf das in einem der anderen Systeme gebucht werden soll, als Präfix in das Kommentar der Buchung geschrieben werden. Diese Option macht nur Sinn, wenn neben Troi noch ein weiteres System ausgewählt wird. Hierfür muss die untere Checkbox aktiviert werden.

#### Jira
Eine Buchung in Jira wird vorgenommen, wenn eine vorher erstellte Jira Verbindung, ein Projekt und ein Ticket ausgewählt wurden. Damit die Buchung funktioniert, müssen alle Werte eingegeben werden. Wichtig: Die Funktionalität wurde ausschließlich mit APIv3 Verbindungen getestet.

#### Redmine
Damit eine Buchung in Redmine funktioniert, muss zunächst die entsprechende Verbindung gewählt werden. Anschließend muss ein Projekt gewählt werden. Wahlweise kann im Anschluss ein Ticket ausgesucht werden, auf das Arbeitszeit gebucht werden soll. Wenn kein Ticket ausgewählt wird, wird die Arbeitszeit auf das ausgewählte Projekt gebucht. Für eine erfolgreiche Buchung ist außerdem die Eingabe der Aktivität notwendig.
### Änderung der Nutzerdaten
Um Nutzerdaten zu ändern, kann auf die Seite "Einstellungen" navigiert werden. Geändert werden kann die E-Mail Adresse und das Passwort.

## Softwarepakete Dritter
Parazei nutzt Open Source Softwarepakete. Ein besonderer Dank geht an alle Entwickler, die sich in der Open Source Comunity für die Entwicklung der folgenden Tools einsetzen:

*Softwarepaet (Lizenz)*

defuse/php-encryption (MIT)     
doctrine/lexer (MIT)    
egulias/email-validator (MIT)   
guzzlehttp/guzzle (MIT)     
guzzlehttp/promises (MIT)       
guzzlehttp/psr7 (MIT)       
hassankhan/config (MIT)     
kbsali/redmine-api (MIT)    
lesstif/php-jira-rest-client (Apache-2.0)       
monolog/monolog  (MIT)      
netresearch/jsonmapper (OSL-3.0)        
paragonie/random_compat (MIT)       
php-curl-class/php-curl-class (Unlicense)   
phpoption/phpoption (Apache-2.0)    
psr/http-client (MIT)       
psr/http-message (MIT)     
psr/log (MIT)
ralouphie/getallheaders (MIT)       
snapappointments/bootstrap-select (MIT)     
symfony/polyfill-ctype (MIT)        
symfony/polyfill-intl-idn (MIT)     
symfony/polyfill-intl-normalizer (MIT)      
symfony/polyfill-php70 (MIT)        
symfony/polyfill-php72 (MIT)        
twbs/bootstrap (MIT)        
vlucas/phpdotenv (BSD-3-Clause)