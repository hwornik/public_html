 <?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen bis ein User angemeldet ist
 */

 class Contentlang {
    
    private $sprache;
    
    public function loadSprache(){
        
        $daten='Willkomen bei Dates Friends Terminplatform<br><br>';
        $daten=$daten.'Die Inhalte dieser Webseite werden mit AES Verschlüsselt!<br><br>';
        $daten=$daten.'Der Schlüssel ist Ihr passwort, das aus Sicherheitsgründen nur einmal, nämlich bei der Registrierung';
        $daten=$daten.'übertragen wird. Dies geschieht aber auch verschlüsselt über den zugesandten Registrierungscode. ';
        $daten=$daten. 'Die Daten der Registrierung selbst werden über dem Browser übermittelten Shlüsel verschlüsselt und es kann ';
        $daten=$daten. ' selbst bei einer Attacke kein Bezug der Daten zu Ihren Konto hergestellt werden, und';
        $daten=$daten. ' es ist ohne Kenntnis von Login und Passwort nicht möglich sich bei ihren Konto Anzumelden. <br>';
         $daten=$daten. ' Weiters sind sie sicher vor Mann-in-the-Middle-Atacken, den die Daten werden nur in Ihren Browser entschlüsselt! <br>';
        $daten=$daten.'<br>';
        
        $this->sprache= array(
        
                $daten,
                'Angezeigter Name: ',
                'Nachname: ',
                'E-Mail-Adresse:',
                'Strasse: ',
                'Land: ',
                'Vorname: ',
                'Login Name: ',
                'E-Mail-Adresse bestätigen:',
                'Wohnort: ',
                'Captcha Code:',
                'Register',
                'Code:',
                'Send to: ',
                'Nachricht',
                'Send',
                'Aktivierungscode: ',
                'Neues Passwort: ',
                'Passwort bestätigen: ',
                'Speichern',
                'Register',
                'Durchsuche die Platform: ',
                'Freundschaftsanfragen',
                'Nickname',
                'Vorname',
                'Nachname',
                'Message',
                'Auswählen',
                'Suchen',
                'Bestätigen',
                'keine Freundschaftsanfragen',
                'Meine Gesuche',
                'Freunde',
                'Nickname',
                'Vorname',
                'Nachname',
                'Auswählen',
                'Freundschaftsanfrage Nachricht',
                'Absenden',
                'Nickname',
                'Vorname',
                'keine Daten',
                'Teilnehmer: ',
                'Nicht bestätigte Termine berücksichtigen',
                'Select Month',
                'Jänner',
                'Februar',
                'März',
                'April',
                'Mai',
                'Juni',
                'July',
                'August',
                'September',
                'Oktober',
                'November',
                'Dezember',
                'Tag',
                'Anfragen',
                'Uhrzeit',
                'Von: ',
                'Format: HH:MM',
                'Bis: ',
                'Ort: ',
                'Termin festlegen',
                'Ausgewählte Termine bestätigen',
                'Ausgewählte Termine ablehnen',
                'Termin von: ',
                'bis: ',
                'in ',
                'Mit:',
                'alle Termine',
                'Zurück',
                'Termine vom ',
                'bis ',
                'Vorwärts',
                'Termin von: ',
                'bis: ',
                'in ',
                'Passwort ändern ',
                'Änderungen speichern',
                'Benutzerbild ändern: ',
                'Hochladen',
                'altes Passwort: ',
                'Neues Passwort: ',
                'Passwort bestätigen: ',
                'Speichern'
        );
        
        return $this->sprache;
        }
    }
 ?>