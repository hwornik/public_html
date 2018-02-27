<?php
$user = $_SESSION["system"];
$brwsr= $_SESSION["browser"];
print("<a href='/'> <h1>Willkommen ".$_SESSION['system']."</h1></a>");
?>
<ul id="menu">
  <li class="button1">Laufen
    <ul>
        <li><a href="?action=sport" class="buttons11">Aktuelles</a></li>
        <li><a href="?action=training" class="buttons12">Training</a></li>
        <li><a href="?action=trchronik" class="buttons13">Laufchronik</a></li>
    </ul>
  </li>
  <li class="button2">Schach 
       <ul>
        <li><a href="?action=schach" class="buttons21" >Aktuelles</a></li>
        <li><a href="?action=schach" class="buttons22" >Partien</a></li>
      </ul>
    </li>
    <li class="button3">Boxen
      <ul>
        <li><a href="?action=tool1" class="buttons31">Aktuelles</a></li>
      </ul>
    </li>
  
    <li  class="button4">Meine Katzen
        <ul>
        <li><a href="?action=games1" class="buttons41">Aktuelles</a></li>
        </ul>
    </li>
  <!--    <li class="button5">Personal 
        <ul>
        <li><a href="/" class="buttons51">Login</a></li>
        </ul>
    </li>
    <li class="button6">Tools
        <ul>
        <li><a href="?action=tool1" class="buttons61">Aktuelles</a> </li>
        </ul>
    </li>
    <li class="button7">Wissen
        <ul>
        <li><a href="http://laufen.wornik.eu" class="buttons71">Laufen</a></li>
        <li><a href="http://windows.wornik.eu" class="buttons72">Windows</a></li>
        <li><a  href="http://linux.wornik.eu" class="buttons73">Linux</a></li>
        <li><a  href="http://infostud.wornik.eu" class="buttons74">Informatik</a></li>
        <li><a  href="http://psystud.wornik.eu" class="buttons75">Psychologie</a></li>
        </ul>
    </li> -->
</ul>
