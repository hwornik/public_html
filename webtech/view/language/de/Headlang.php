 <?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen bis ein User angemeldet ist
 */

 class Headlang {
    
    private $sprache;
    
    public function loadSprache(){
        
        $this->sprache= array(
            'Username: ',
            'PC speichern',
            'login',
            'Registrieren',
            'Login:',
            'login',
            'Registrieren',
            'PC speichern',
            'Abmelden',
            'Einstellungen',
            'Sichere Übertragung',
            'U/P vergessen?'
        );
        
        return $this->sprache;
        }
}
?>