 <?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen bis ein User angemeldet ist
 */

 class Buch {
    
    private $sprache;
    
    public function loadSprache(){
        
        $this->sprache= array(
        
            ' log dich ein oder registriere dich',
            'Javascript ausgeschaltet keine Verschlüsselung/sicherer Datenverkehr möglich',
            'Sie haben sich erfolgreich registriert',
            'Falsches Passwort oder Username',
            'Account Erfolgreich aktiviert',
            'Fehler bei der Aktivierung',
            'Falscher Code, Aktivierung fehlgeschlagen',
            'Übersicht über alle Veränderungen',
            'Alle Nachrichten an mich und von mir',
            'Freunde verwalten und suchen',
            'Eine Nachricht an meine Freunde senden',
            'Neue Freunde suchen',
            'Über längere Zeit eingelogt bleiben',
            'Einen Termin mit meinen Freunden ausmachen',
            'Terminvorschläge von meinen Freunden mit mir bestätigen',
            'Meine Termine Heute',
            'Meine Termine Morgen',
            'Meine Termine diese Woche',
            'Meine Termine in den nächsten 4 Wochen',
            'Meine gesammten Termine',  
            'Sie bekommen ihren usernamen und einen code zugeschickt, <br> mit dem sie ein neues Passwort eingeben können',
             'Sie bekommen ihren usernamen zugeschickt', 
             'Sie bekommen einen code zugeschickt, mit dem sie ein neues Passwort eingeben können',
             'Fehler sie haben keine  Aktion ausgewählt',
             'keine gültige emailadresse',
             'Username oder Passwort falsch',
             'Falsche Eingabe',
             'Eingabe erforderlich',
             'ungültiger Link'
             );
        
        return $this->sprache;
    }
    
 }
 ?>