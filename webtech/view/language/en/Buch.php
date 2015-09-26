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
        
        $sprache= array(
        
                   
            ' log in or register yourself',
            'Javascript disabled no secure mode possibel',
            'registration completed',
            'wrong password or username',
            'account aktivated',
            'aktivation failure, please retry',
            'wrong code, aktivation failed',
            'overlock of changes',
            'all messages from me or to me',
            'manage friends and search for new',
            'send a message to my friends',
            'search for new friends',
            'stay logged in',
            'make an appointment',
            'cancel or confirm an appointment',
            'todays appointments',
            'tomorrow appointments',
            'appointments this week',
            'appointments next four weeks',
            'all apointments' 
        );
        
        return $sprache;
    }
    
 }
 ?>