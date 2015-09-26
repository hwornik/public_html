 <?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen bis ein User angemeldet ist
 */

 class Rightbarlang {
    
    private $sprache;
    
    public function loadSprache(){
        
        $this->sprache= array(
            'Neuer Termin',
            'Termine Bestätigen',
            'Termine',
            'Heute',
            'Morgen',
            'Woche',
            'Monat+',
            'Alle'
            
        );
        
        return $this->sprache;
        }
}
?>