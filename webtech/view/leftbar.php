<?php
class Leftbar {
    
    public function anfang() {
        print('<leftbar>');
    }
    
    public function normal() {
        
        print('<a href="?neuigkeiten">Neuigkeiten</a><br><br>'); 
        print('<a href="?freunde">Freunde</a><br><br>'); 
        print('<a href="?nachrichtneu">Nachricht senden</a><br>'); 
    }
    
    public function ende() {
        print('</leftbar>');
    }
}


