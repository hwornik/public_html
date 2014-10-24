<?php
class Rightbar {
    
    public function anfang() {
        print('<rightbar>');
    }

        public function normal() {
        
        print('<a href="?Termin=ok&terminneu=ok">Neuer Termin</a><br>'); 
        print('<a href="?Termin=ok&bestatigen">Termine Bestätigen</a><br><br>'); 
        print('<ueber>Termine</ueber><br>'); 
        print('<a href="?Termin=ok&heute">Heute</a><br>'); 
        print('<a href="?Termin=ok&morgen">Morgen</a><br>');
        print('<a href="?Termin=ok&woche">Woche</a><br>'); 
        print('<a href="?Termin=ok&monat">Monat+</a><br>'); 
        print('<a href="?Termin=ok&alle">Alle</a><br>'); 
        
    }
    
    public function ende() {
        print('</rightbar>');
    }
}


