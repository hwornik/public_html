<?php
	
class Content {
    


    public function anfang() {
        print('<content>');
    }
    
        public function ende() {
        print('</content>');
    }

    public function normal() {
        
        $daten='Willkomen bei Dates Friends Terminplatform<br><br>';
        $daten=$daten.'Die Inhalte dieser Webseite werden mit AES Verschlüsselt!<br><br>';
        $daten=$daten.'Der Schlüssel ist Ihr passwort, das aus Sicherheitsgründen nur einmal, nämlich bei der Registrierung';
        $daten=$daten.'übertragen wird. Dies geschieht aber auch verschlüsselt über den zugesandten Registrierungscode. ';
        $daten=$daten. 'Die Daten der Registrierung selbst werden über dem Browser übermittelten Shlüsel verschlüsselt und es kann ';
        $daten=$daten. ' selbst bei einer Attacke kein Bezug der Daten zu Ihren Konto hergestellt werden, und';
        $daten=$daten. ' es ist ohne Kenntnis von Login und Passwort nicht möglich sich bei ihren Konto Anzumelden. <br>';
        $daten=$daten.'<br>';
        echo $daten;
          
    }
    
    public function fehler($daten) {
        
        $daten=$daten.'<br>';
        echo  $daten;
          
    }
    
    public function register($schl,$key,$werte,$captchares,$fehlerwerte) {
  
        $daten='<jvcodes><input id="keycode" type="hidden" id="key" value="'.$key.'"></jvcodes>'
        .'<registerform><input type="hidden" name="identifier" value="'.$schl.'">'
        .'Angezeigter Name: <input type="hidden"name="angzname" value="'.$werte["angzname"].'"><fehler>'.$fehlerwerte['angzname'].'</fehler><br><br>
        Vorname: <input type="hidden" name="vname" value="'.$werte["vname"].'"><fehler>'.$fehlerwerte['vname'].'</fehler><br><br>
        Nachname: <input type="hidden"  name="nname" value="'.$werte["nname"].'"><fehler>'.$fehlerwerte['nname'].'</fehler><br><br>
        Login Name: <input type="hidden" name="logon" value=""><fehler>'.$fehlerwerte['logon'].'</fehler><br><br>
        E-Mail-Adresse:<input type="hidden" name="email" value="'.$werte["email"].'"><fehler>'.$fehlerwerte['email'].'</fehler><br><br>
        E-Mail-Adresse bestätigen:<input type="hidden"name="email2" autocomplete="off" value="'.$werte["email2"].'"><fehler>'.$fehlerwerte['email2'].'</fehler><br><br>
        Strasse: <input type="hidden" name="str" value="'.$werte["str"].'"><fehler>'.$fehlerwerte['str'].'</fehler><br><br>
        Wohnort: <input type="hidden"  name="ort" value="'.$werte["ort"].'"><fehler>'.$fehlerwerte['ort'].'</fehler><br><br>
        Land: <input type="hidden" name="land" value="'.$werte["land"].'"><fehler>'.$fehlerwerte['land'].'</fehler><br><br>
        <img onload="enccode()" id="captcha" src="./securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
        <input class="nimg"type="text" name="captcha_code" size="10" value="" maxlength="6"/><nimgfehler>'.$captchares.'</nimgfehler>
        Captcha Code:<p class="nimgtext" >Code:</p>'
        .'<button type="submit" value="Register" onclick="person.sendformReg()" formaction="?Register">Register</button></registerform>';

        echo $daten;

    }
    
    public function neuenachricht($code,$freunde) {
        
        echo '<input type="hidden" id="identifier" value="'.$code.'">';
        $counter=0;
        echo '<input type="Radio" name="artikel" value="'.$counter.'" checked="checked" >Meine Pinnwand';
        $counter++;
        if(!is_null($freunde))
        {
        foreach ($freunde as $row) {
                    echo '<input type="Radio" name="artikel" value="'.$counter.'"><text>'.$row['vname'].'</text> <text>'.$row['nname'].'</text>\'s Pinnwand';
                    $counter++;
                }
        }
        echo '<div>  
                   <label for="textfeld" >Nachricht</label><br>
                      <textarea id="textfeld" cols="35" rows="4" style="width:90%" ></textarea><br> 	
                   <button onclick="nachricht.sendNachricht()" />Posten</button></p>
                </div>';
 
    }

    public function regLogon($jcsrpt) {
        
        $datenphpanf='<form action="?actconfirm" method="post">';
        $daten='<registerform>Aktivierungscode: <input type="password"  name="code"><br>
                Neues Passwort: <input type="password"  name="passwt" ><br>
                Passwort bestätigen: <input type="password"  name="passwt2" ><br>';
        $datensecend='<button  onclick="person.sendformActivat()" >Speichern</button></registerform>';
        $datenphpend='<button type="submit" value="Register">Register</button></form></registerform>';
        if($jcsrpt)
        {
            return $daten.$datensecend;
        }
        else 
        {
            return $datenphpanf.$daten.$datenphpend;
        }
    }
    
    public function sendChallenge($chall) {
        
        print('<jvcodes><input type="hidden" id="key" value="'.$chall.'"></jvcodes>');
    }
    
    
    public function sucheFreund($code,$anfrg,$gesuche,$freunde) {
        $counter=0;
        echo '<input type="hidden" id="identifier" value="'.$code.'">';
        echo'<h3>Durchsuche die Platform: <input id="suchfreund" type="text">';
        echo '<button  onclick="friends.sucheFreunde()" >Suchen</button>';
        echo '<br><br>Freundschaftsanfragen</h3>';
        if(count($anfrg)>0)
        {
            echo "<table width=\"100%\">\n";
            echo "<tr>\n";
            echo "<th>Nickname</th>";
            echo "<th>Vorname</th>";
            echo "<th>Nachname</th>";
            echo "<th>Message</th>";
            echo "<th>Auswählen</th>";
            echo "</tr>";
            if(!is_null($anfrg))
            {
                foreach ($anfrg as $row) {
                    echo "<tr>";
                    if(!is_null($row))
                    {
                        foreach($row as $key => $val)
                        {
                                echo "<td>$val</td>";
                        }
                    }
                    echo "<td><input type=\"checkbox\" name=\"ausstattung[]\" value=\"$counter\"></td>";
                    echo "</tr>\n";
                    $counter++;
                }
            }
                echo "</table>\n";
                echo '<button type="submit" value="Bestätigen" onclick="friends.bestAnfrage()" />Bestätigen</button>';
        }
        else 
        {
            echo 'keine Freundschaftsanfragen';
        }
        $this->showUserTable($gesuche,'Meine Gesuche');
        $this->showUserTable($freunde,'Freunde');

    }
    
    public function showFriendssearch($schl,$dbresult)  {
    $counter=0;
    echo '<input type="hidden" name="identifier" value="'.$schl.'">';
    echo "<table width=\"100%\">\n";
    echo "<tr>\n";
    echo "<th>Nickname</th>";
    echo "<th>Vorname</th>";
    echo "<th>Nachname</th>";
    echo "<th>Auswählen</th>";
    echo "</tr>";
    if(!is_null($dbresult))
    {
        foreach ($dbresult as $row) {
            echo "<tr>";
            if(!is_null($row))
            {
                foreach($row as $key => $val)
                {
                        echo "<td>$val</td>";
                }
            }
            echo "<td><input type=\"checkbox\" name=\"ausstattung[]\" value=\"$counter\"></td>";
            echo "</tr>\n";
            $counter++;
        }
    }
    echo "</table>\n";
    $data=' <div>  
                   <label for="textfeld" >Freundschaftsanfrage Nachricht</label><br>
                      <textarea id="textfeld" cols="35" rows="4" style="width:90%" ></textarea><br> 	
                   <button type="submit" value="Absenden" onclick="friends.sendAnfrage()" />Absenden</button>
                </div>';

    echo $data;
    }
    
    public function showUserTable($dbresult,$title) {
 
        echo "<h3>$title</h3>";
        if(!is_null($dbresult))
        {
        echo "<table width=\"100%\">\n";
        echo "<tr>\n";
        echo "<th>Nickname</th>";
        echo "<th>Vorname</th>";
        echo "<th>Nachname</th>";
        echo "</tr>";
        if(!is_null($dbresult))
        {
        foreach ($dbresult as $row) {
                echo "<tr>";
                if(!is_null($row))
                {
                    foreach($row as $key => $val)
                    {
                            echo "<td>$val</td>";
                    }
                }
                echo "</tr>\n";
                $counter++;
            }
        }
        echo "</table>\n";
        }
        else {
            echo 'keine Daten';
        }
    }
    
    public function showNeuigkeiten( $dbresult)  {
        if(!is_null($dbresult))
        {
          //echo '<input type="hidden" name="identifier" value="'.$schl.'"><br>';
          foreach ($dbresult as $row) {
              echo '<text>'.$row['useridfrom'].'</text> '.'<text>'.$row['datum'].'</text> <br>'.'<text>'.$row['message'].'</text> <br><br>';
          }
        }
    }
    
    public function neuerTermin($code,$freunde)  {
        echo '<input type="hidden" id="identifier" value="'.$code.'">';
        $counter=0;
        echo '<input type="hidden" name="identifier" value="'.$schl.'">';
        echo 'Teilnehmer: <br>';
        if(!is_null($freunde))
        {
            foreach ($freunde as $row) {
                    echo '<input type="Checkbox" name="artikel" value="'.$counter.'"><text>'.$row['vname'].'</text> <text>'.$row['nname'].'</text>';
                    $counter++;
                }
        }
        echo '<br><br>';
        echo '<input type="Checkbox" name="offene" value="-1">Nicht bestätigte Termine berücksichtigen<br><br>';
        $this->dropDate();
    }
    
    public function dropDate() {
        
        echo "<table border=\"0\" cellspacing=\"0\" >
            <tr><td  align=left  > 
            Monat <select id='month' value=''>Select Month</option>
            <option value='01'>Jänner</option>
            <option value='02'>Februar</option>
            <option value='03'>Märt</option>
            <option value='04'>April</option>
            <option value='05'>Mai</option>
            <option value='06'>Juni</option>
            <option value='07'>July</option>
            <option value='08'>August</option>
            <option value='09'>September</option>
            <option value='10'>October</option>
            <option value='11'>November</option>
            <option value='12'>Dezember</option>
            </select>

            </td><td  align=left  >  
            Tag<select id='tag' >
            <option value='01'>01</option>
            <option value='02'>02</option>
            <option value='03'>03</option>
            <option value='04'>04</option>
            <option value='05'>05</option>
            <option value='06'>06</option>
            <option value='07'>07</option>
            <option value='08'>08</option>
            <option value='09'>09</option>
            <option value='10'>10</option>
            <option value='11'>11</option>
            <option value='12'>12</option>
            <option value='13'>13</option>
            <option value='14'>14</option>
            <option value='15'>15</option>
            <option value='16'>16</option>
            <option value='17'>17</option>
            <option value='18'>18</option>
            <option value='19'>19</option>
            <option value='20'>20</option>
            <option value='21'>21</option>
            <option value='22'>22</option>
            <option value='23'>23</option>
            <option value='24'>24</option>
            <option value='25'>25</option>
            <option value='26'>26</option>
            <option value='27'>27</option>
            <option value='28'>28</option>
            <option value='29'>29</option>
            <option value='30'>30</option>
            <option value='31'>31</option>
            </select>
            </td><td  align=left  >   
            Year(yyyy)<input type=text id='year' size=4 value=2012>
            </table><button onclick='termin.sendDateTag()' >Anfragen</button>";
    }
    
    public function selectTermin($code,$date,$terminFr) {

        echo '<input type="hidden" id="identifier" value="'.$code.'">';
        echo '<h3>'.date("m.d.y",$date ).'</h3>';
        if(!is_null($terminFr))
        {
            foreach ($terminFr as $row) {
                echo '<h3><enctext>'.$row['freundname'].'</enctext></h3>';
                echo '<enctext>'.$row['werte'].'</enctext>' ;  
            }
        }
        echo'<h4> Uhrzeit<br> Von: <input type="text" >Format: HH:MM<br> Bis: <input type="text"> Format: HH:MM</h4>';
        echo 'Ort: <input type="text"><br>';
        echo '<input type="hidden"><br>';
        echo '<button onclick="termin.terminbuchen()" >Termin festlegen</button>';
    }
    
    public function showOffeneTermine($code,$dbresult) {
                echo '<input type="hidden" id="identifier" value="'.$code.'">';
                echo '<button onclick="termin.terminbestaetigen()" >Ausgewählte Termine bestätigen</button>';
                echo '<button onclick="termin.terminablehen()" >Ausgewählte Termine ablehnen</button><br>';

                $counter=0;
                if(!is_null($dbresult))
                {
                    foreach($dbresult as $rowa)
                    {
                            echo '<input type="Checkbox" name="artikel" value="'.$counter.'">';
                            echo 'Termin von: <enctext>'.$rowa['termin']['von'].'</enctext> bis: <enctext>'.$rowa['termin']['bis'].'</enctext> in <enctext>'.$rowa['termin']['ort'].'</enctext>';
                            echo '<enctext>'.$rowa['termin']['text'].'</enctext><br>Mit:<br>';
                            if(!is_null($rowa['user']))
                            {
                                foreach($rowa['user'] as $rowu)
                                {
                                    echo '<enctext>'.$rowu['vname'].'</enctext> <enctext>'.$rowu['nname'].'</enctext> '.$rowu['nimtteil'].' <enctext>'.$rowu['grund'].'</enctext><br>';
                                }
                            }
 
                    }
                }
    }
    
    public function showTermine($timea,$timeb,$dbresult,$butt) {
                if($timeb==0)
                {
                    echo '<h3>alle Termine</h3>';
                }
                else 
                {
                    echo '<h3>';
                    if($butt)
                    {
                        echo '<button onclick="termin.zuruck()" >Zurück</button>';
                    }
                    echo 'Termine vom '.date('G:i d.m.y',$timea).' bis '.date('G:i d.m.y',$timeb).' ';
                    if($butt)
                    {
                        echo '<button onclick="termin.vor()" >Vorwärts</button>';
                    }
                    echo '</h3>';
                }
                if(!is_null($dbresult))
                {
                    foreach($dbresult as $rowa)
                    {
                            echo 'Termin von: <enctext>'.$rowa['termin']['von'].'</enctext> bis: <enctext>'.$rowa['termin']['bis'].'</enctext> in <enctext>'.$rowa['termin']['ort'].'</enctext>';
                            echo '<enctext>'.$rowa['termin']['text'].'</enctext><br>Mit:<br>';
                            if(!is_null($rowa['user']))
                            {
                                foreach($rowa['user'] as $rowu)
                                {
                                    echo '<enctext>'.$rowu['vname'].'</enctext> <enctext>'.$rowu['nname'].'</enctext> '.$rowu['nimtteil'].' <enctext>'.$rowu['grund'].'</enctext><br>';
                                }
                            }
                            echo '<br>';
                    }
                }
    }
    
    public function einstellungen($schl,$werte,$fehlerwerte) {
  
 
        echo '<registerform><input type="hidden" name="identifier" value="'.$schl.'">'
        .'Angezeigter Name: <input type="hidden"name="angzname" value="'.$werte["angzname"].'"><fehler>'.$fehlerwerte['angzname'].'</fehler><br><br>
        Vorname: <input type="hidden" name="vname" value="'.$werte["vname"].'"><fehler>'.$fehlerwerte['vname'].'</fehler><br><br>
        Nachname: <input type="hidden"  name="nname" value="'.$werte["nname"].'"><fehler>'.$fehlerwerte['nname'].'</fehler><br><br>
        Passwort ändern <button id="passbutton" onclick="person.aenderePassw()" >Passwort ändern</button><br><br>
        E-Mail-Adresse:<input type="hidden" name="email" value="'.$werte["email"].'"><fehler>'.$fehlerwerte['email'].'</fehler><br><br>
        Strasse: <input type="hidden" name="str" value="'.$werte["str"].'"><fehler>'.$fehlerwerte['str'].'</fehler><br><br>
        Wohnort: <input type="hidden"  name="ort" value="'.$werte["ort"].'"><fehler>'.$fehlerwerte['ort'].'</fehler><br><br>
        Land: <input type="hidden" name="land" value="'.$werte["land"].'"><fehler>'.$fehlerwerte['land'].'</fehler><br><br>
        <button id="speicherEin" value="Register" onclick="person.speichereEin()" >Änderungen speichern</button></registerform>';

echo '<form action="?upload" method="post" enctype="multipart/form-data">
        Benutzerbild ändern: <input type="file" name="datei">
        <input type="submit" value="Hochladen">
        </form>';
    }
    
    public function aenderP($code) {
        
        echo '<registerform><input type="hidden" name="identifier" value="'.$code.'">';
        $daten='<registerform>altes Passwort: <input type="password"  name="code"><br>
                Neues Passwort: <input type="password"  name="passwt" ><br>
                Passwort bestätigen: <input type="password"  name="passwt2" ><br>';
        $datensecend='<button  onclick="person.storeneuesPass()" >Speichern</button></registerform>';
 
        echo $daten.$datensecend;

    }
}


