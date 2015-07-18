<?php 
class Navbar {
    public function show() {
        print('<div id="mainMenu"> </div>
            <div id="menuakt">
                <p id="aktiviert"></p>
            </div> 
            <div id="menutext">
               <p id="Laufen">Laufen</p>
               <p id="Tools">Boxen</p>
               <p id="Games">Schach</p>
             </div>
            <p id="submenuback"></p>
            <p id="menuLine"></p>
            <div id="rmaktuell">
            <p class="aktuell"></p>
            </div>
            <div id="Laufmenu">
                    <p class="Laufbutton1">Aktuelles</p>
                    <p class="Toolbutton1">Aktuelles</p>
                    <p class="Gamebutton1">Aktuelles</p>
                    <p class="Chronikbutton1">Aktuelles</p>
                    <p class="Laufbutton2">Training</p>
                    <p class="Laufbutton3">Laufchronik</p>
            </div>');
    }
}
?>








