<?php
require_once '../classes/DBUsers.php';

class Mailer
{
    public function sendRegistrationMain($mail): bool
    {
        $subject = 'PZB Registrierung erfolgreich';
        $message = '<html>' .
            '<head>' .
            '<title>Willkommen bei der parallelen Zeiterfassung!</title>' .
            '</head>' .
            '<body>' .
            '<p>Deine Registrierung war erfolgreich. Viel Spaß bei der Nutzung!</p>' .
            '</body>' .
            '</html>';
        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/html; charset=utf-8';
        return mail($mail, $subject, $message, implode("\r\n", $header));
    }

    public function sendNewMailMessage($newMail): bool
    {
        $subject = 'PZB E-Mail erfolgreich geändert';
        $message = '<html>' .
            '<head>' .
            '<title>E-Mail bei der parallelen Zeiterfassung erfolgreich gewechselt</title>' .
            '</head>' .
            '<body>' .
            '<p>Du hast erfolgreich deine E-Mail Adresse bei der parallelen Zeiterfassung geändert. Bitte nutze in Zukunft diese Adresse für den Login.</p>' .
            '</body>' .
            '</html>';
        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/html; charset=utf-8';
        return mail($newMail, $subject, $message, implode("\r\n", $header));
    }

    public function sendNewPasswordInfoMail($mail): bool
    {
        $dbUsers = new DBUsers();
        $subject = 'PZB neues Passwort';
        $message = '<html>' .
            '<head>' .
            '<title>Passwort bei der parallelen Zeiterfassung erfolgreich gewechselt</title>' .
            '</head>' .
            '<body>' .
            '<p>Du hast erfolgreich dein Passwort bei der parallelen Zeiterfassung geändert. Bitte nutze in Zukunft das neue Passwort für den Login.</p>' .
            '</body>' .
            '</html>';
        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/html; charset=utf-8';
        return mail($dbUsers->getMailByUserId($_SESSION['userid']), $subject, $message, implode("\r\n", $header));
    }

    public function sendNewPassword($mail, $newPassword): bool
    {
        $subject = 'PZB | Neues Passwort';
        $message = '<html>' .
            '<head>' .
            '<title>Parallele Zeiterfassung Neues Passwort</title>' .
            '</head>' .
            '<body>' .
            '<p>Das Zurücksetzen deines Passworts war erfolgreich! Dein neues Passwort lautet: ' . $newPassword . '</p>' .
            '</body>' .
            '</html>';
        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/html; charset=utf-8';
        return mail($mail, $subject, $message, implode("\r\n", $header));
    }
}