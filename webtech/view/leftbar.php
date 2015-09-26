<?php
require_once $_SESSION['pfad'].'/view/language/'.$_SESSION['language'].'/Leftbarlang.php';
class Leftbar {
    
    private $sprache;
    
    public function anfang() {
        print('<leftbar>');
    }
    
    public function normal() {
        $lang= new Leftbarlang();
        $this->sprache=$lang->loadSprache();
        print('<a id="Homelink" href="?home">'.$this->sprache[0].'</a><br><br>'); 
        print('<a id="Neuigklink" href="?neuigkeiten">'.$this->sprache[1].'</a><br><br>');
        print('<a id="Nachrichtlink" href="?nachrichtneu">'.$this->sprache[2].'</a><br><br>'); 
        print('<a id="Freundelink" href="?freunde">'.$this->sprache[3].'</a><br><br>'); 
     }
    
    public function ende() {
        print('</leftbar>');
    }
}


