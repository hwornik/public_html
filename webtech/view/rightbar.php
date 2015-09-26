<?php
require_once $_SESSION['pfad'].'/view/language/'.$_SESSION['language'].'/Rightbarlang.php';

class Rightbar {
    
     private $sprache;
    
    public function anfang() {
        print('<rightbar>');
    }

        public function normal() {
        $lang= new Rightbarlang();
        $this->sprache=$lang->loadSprache();
        
        print('<a href="?Termin=ok&terminneu=ok" id="neuterminlink" >'.$this->sprache[0].'</a><br>'); 
        print('<a href="?Termin=ok&bestatigen" id="terminbestlink" >'.$this->sprache[1].'</a><br><br>'); 
        print('<ueber>'.$this->sprache[2].'</ueber><br>'); 
        print('<a href="?Termin=ok&heute" id="terminheutelink" >'.$this->sprache[3].'</a><br>'); 
        print('<a href="?Termin=ok&morgen" id="terminmorgenlink" >'.$this->sprache[4].'</a><br>');
        print('<a href="?Termin=ok&woche" id="terminwochelink" >'.$this->sprache[5].'</a><br>'); 
        print('<a href="?Termin=ok&monat" id="terminmonatlink" >'.$this->sprache[6].'</a><br>'); 
        print('<a href="?Termin=ok&alle" id="terminallelink" >'.$this->sprache[7].'</a><br>'); 
        
    }
    
    public function ende() {
        print('</rightbar>');
    }
}


