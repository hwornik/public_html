<?php
	
require_once $_SESSION['pfad'].'/view/language/'.$_SESSION['language'].'/Contentlang.php';
class Content {
    
    private $sprache;

    public function anfang() {
        $lang= new Contentlang();
        $this->sprache=$lang->loadSprache();
        print('<content>');
        
    }
    
        public function ende() {
        print('</content>');
    }

    public function normal() {

        echo $this->sprache[0];
         
    }
    
    public function fehler($daten) {
        
        $daten=$daten.'<br>';
        echo  $daten;
          
    }
    
    public function register($schl,$key,$werte,$captchares,$fehlerwerte) {
  
        $daten='<registerform><jvcodes><input id="keycode" type="hidden" id="key" value="'.$key.'"></jvcodes>';
        $daten=$daten.'<input type="hidden" name="identifier" value="'.$schl.'">';
        $daten=$daten.$this->sprache[1].'<input type="hidden" name="angzname" value="'.$werte["angzname"].'"><fehler>'.$fehlerwerte['angzname'].'</fehler><br><br>'.$this->sprache[6].'<input type="hidden" name="vname" value="'.$werte["vname"].'"><fehler>'.$fehlerwerte['vname'].'</fehler><br><br>';
        $daten=$daten.$this->sprache[2].'<input type="hidden"  name="nname" value="'.$werte["nname"].'"><fehler>'.$fehlerwerte['nname'].'</fehler><br><br>'.$this->sprache[7].'<input type="hidden" name="logon" value="'.$werte["logon"].'"><fehler>'.$fehlerwerte['logon'].'</fehler><br><br>';
        $daten=$daten.$this->sprache[3].'<input type="hidden" name="email" value="'.$werte["email"].'"><fehler>'.$fehlerwerte['email'].'</fehler><br><br>'.$this->sprache[8].'<input type="hidden"name="email2" autocomplete="off" value="'.$werte["email2"].'"><fehler>'.$fehlerwerte['email2'].'</fehler><br><br>';
        $daten=$daten.$this->sprache[4].'<input type="hidden" name="str" value="'.$werte["str"].'"><fehler>'.$fehlerwerte['str'].'</fehler><br><br>'.$this->sprache[9].'<input type="hidden"  name="ort" value="'.$werte["ort"].'"><fehler>'.$fehlerwerte['ort'].'</fehler><br><br>';
        $daten=$daten.$this->sprache[5].'<input type="hidden" name="land" value="'.$werte["land"].'"><fehler>'.$fehlerwerte['land'].'</fehler><br><br><img onload="enccode()" id="captcha" src="./securimage/securimage_show.php" alt="CAPTCHA Image" /><br>';
        $daten=$daten.'<input class="nimg"type="text" name="captcha_code" size="10" value="" maxlength="6"/><nimgfehler>'.$fehlerwerte["capcha"].$captchares.'</nimgfehler>'.$this->sprache[10].'<p class="nimgtext" >'.$this->sprache[12].'</p>';
        $daten=$daten.'<button type="submit" value="Register" onclick="person.sendformReg()" formaction="?Register">'.$this->sprache[11].'</button></registerform>';

        echo $daten;

    }
    
    public function neuenachricht($code,$freunde) {
        echo '<div>  
           <label for="textfeld" >'.$this->sprache[14].'</label><br>
              <textarea id="textfeld" data-dojo-type="dijit/form/Textarea" cols="35" rows="4" style="width:90%" ></textarea><br> 	
        </div>';
        echo '<input type="hidden" id="identifier" value="'.$code.'">';
        $counter=0;
        echo $this->sprache[13];
                            echo '<input type="checkbox" data-dojo-type="dijit/form/CheckBox" name="artikel" value="'.$counter.'">ALL <br>';
        if(!is_null($freunde))
        {
        foreach ($freunde as $row) {
                    echo '<input  data-dojo-type="dijit/form/CheckBox" name="artikel" value="'.$counter.'"><text>'.$row['vname'].'</text> <text>'.$row['nname'].'</text> ';
                    $counter++;
                }
        }
        echo '<br><button class="button1" data-dojo-type="dijit/form/Button" onclick="nachricht.sendNachricht()" />'.$this->sprache[15].'</button></p>';
    }

    public function regLogon($jcsrpt) {
        
        $datenphpanf='<form action="?actconfirm" method="post">';
        $daten='<registerform>'.$this->sprache[16].'<input type="password"  name="code"><br>
                '.$this->sprache[17].'<input type="password"  name="passwt" ><br>
                '.$this->sprache[18].'<input type="password"  name="passwt2" ><br>';
        $datensecend='<button  onclick="person.sendformActivat()" >'.$this->sprache[19].'</button></registerform>';
        $datenphpend='<button type="submit" value="Register">'.$this->sprache[20].'</button></form></registerform>';
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
        echo'<h3>'.$this->sprache[21].'<input id="suchfreund" type="text">';
        echo '<button  onclick="friends.sucheFreunde()" >'.$this->sprache[28].'</button>';
        echo '<br><br>'.$this->sprache[22].'</h3>';
        if(count($anfrg)>0)
        {
            echo "<table width=\"100%\">\n";
            echo "<tr>\n";
            echo "<th>".$this->sprache[23]."</th>";
            echo "<th>".$this->sprache[24]."</th>";
            echo "<th>".$this->sprache[25]."</th>";
            echo "<th>".$this->sprache[26]."</th>";
            echo "<th>".$this->sprache[27]."</th>";
            echo "</tr>";
            if(!is_null($anfrg))
            {
                foreach ($anfrg as $row) {
                    echo "<tr>";
                    if(!is_null($row))
                    {
                        foreach($row as $key => $val)
                        {
                                echo "<td>".$val."</td>";
                        }
                    }
                    echo "<td><input type=\"checkbox\" name=\"ausstattung[]\" value=\"$counter\"></td>";
                    echo "</tr>\n";
                    $counter++;
                }
            }
                echo "</table>\n";
                echo '<button type="submit" value="Bestätigen" onclick="friends.bestAnfrage()" />'.$this->sprache[29].'</button>';
        }
        else 
        {
            echo $this->sprache[30];
        }
        $this->showUserTable($gesuche,$this->sprache[31]);
        $this->showUserTable($freunde,$this->sprache[32]);

    }
    
    public function showFriendssearch($schl,$dbresult)  {
    $counter=0;
    echo '<input type="hidden" name="identifier" value="'.$schl.'">';
    echo "<table width=\"100%\">\n";
    echo "<tr>\n";
    echo "<th>".$this->sprache[33]."</th>";
    echo "<th>".$this->sprache[34]."</th>";
    echo "<th>".$this->sprache[35]."</th>";
    echo "<th>".$this->sprache[36]."</th>";
    echo "</tr>";
    if(!is_null($dbresult))
    {
        foreach ($dbresult as $row) {
            echo "<tr>";
            if(!is_null($row))
            {
                foreach($row as $key => $val)
                {
                        echo "<td>".$val."</td>";
                }
            }
            echo "<td><input type=\"checkbox\" name=\"ausstattung[]\" value=\"$counter\"></td>";
            echo "</tr>\n";
            $counter++;
        }
    }
    echo "</table>\n";
    $data=' <div>  
                   <label for="textfeld" >'.$this->sprache[37].'</label><br>
                      <textarea id="textfeld" cols="35" rows="4" style="width:90%" ></textarea><br> 	
                   <button type="submit" value="Absenden" onclick="friends.sendAnfrage()" />'.$this->sprache[38].'</button>
                </div>';

    echo $data;
    }
    
    public function showUserTable($dbresult,$title) {
        $counter=0;
        echo "<h3>".$title."</h3>";
        if(!is_null($dbresult))
        {
        echo "<table width=\"100%\">\n";
        echo "<tr>\n";
        echo "<th>".$this->sprache[39]."</th>";
        echo "<th>".$this->sprache[40]."</th>";
        echo "<th>".$this->sprache[41]."</th>";
        echo "</tr>";
        if(!is_null($dbresult))
        {
        foreach ($dbresult as $row) {
                echo "<tr>";
                if(!is_null($row))
                {
                    foreach($row as $key => $val)
                    {
                            echo "<td>".$val."</td>";
                    }
                }
                echo "</tr>\n";
                $counter++;
            }
        }
        echo "</table>\n";
        }
        else {
            echo $this->sprache[42];
        }
    }
    
    public function showNeuigkeiten( $dbresult)  {
        if(!is_null($dbresult))
        {
          //echo '<input type="hidden" name="identifier" value="'.$schl.'"><br>';
          foreach ($dbresult as $row) {
              echo '<text>'.$row['useridfrom'].'</text> <text>'.$row['datum'].'</text> <br> <text>'.$row['message'].'</text> <br><br>';
          }
        }
    }
    
    public function neuerTermin($code,$freunde)  {
        echo '<input type="hidden" id="identifier" value="'.$code.'">';
        $counter=0;
        echo '<input type="hidden" name="identifier" value="'.$schl.'">';
        echo $this->sprache[43].'<br>';
        if(!is_null($freunde))
        {
            foreach ($freunde as $row) {
                    echo '<input type="Checkbox" name="artikel" value="'.$counter.'"><text>'.$row['vname'].'</text> <text>'.$row['nname'].'</text>';
                    $counter++;
                }
        }
        echo '<br><br>';
        echo '<input type="Checkbox" name="offene" value="-1">'.$this->sprache[44].'<br><br>';
        $this->dropDate();
    }
    
    public function dropDate() {
        
        echo "<table border=\"0\" cellspacing=\"0\" >
            <tr><td  align=left  > 
            Monat <select id='month' value=''>".$this->sprache[45]."</option>
            <option value='01'>".$this->sprache[46]."</option>
            <option value='02'>".$this->sprache[47]."</option>
            <option value='03'>".$this->sprache[48]."</option>
            <option value='04'>".$this->sprache[49]."</option>
            <option value='05'>".$this->sprache[50]."</option>
            <option value='06'>".$this->sprache[51]."</option>
            <option value='07'>".$this->sprache[52]."</option>
            <option value='08'>".$this->sprache[53]."</option>
            <option value='09'>".$this->sprache[54]."</option>
            <option value='10'>".$this->sprache[55]."</option>
            <option value='11'>".$this->sprache[56]."</option>
            <option value='12'>".$this->sprache[57]."</option>
            </select>

            </td><td  align=left  >  
            ".$this->sprache[58]."<select id='tag' >
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
            </table><button onclick='termin.sendDateTag()' >".$this->sprache[59]."</button>";
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
        echo'<h4> '.$this->sprache[60].'<br> '.$this->sprache[61].'<input type="text" >'.$this->sprache[62].'<br> '.$this->sprache[63].'<input type="text"> '.$this->sprache[62].'</h4>';
        echo $this->sprache[64].'<input type="text"><br>';
        echo '<input type="hidden"><br>';
        echo '<button onclick="termin.terminbuchen()" >'.$this->sprache[65].'<</button>';
    }
    
    public function showOffeneTermine($code,$dbresult) {
                echo '<input type="hidden" id="identifier" value="'.$code.'">';
                echo '<button onclick="termin.terminbestaetigen()" >'.$this->sprache[66].'</button>';
                echo '<button onclick="termin.terminablehen()" >'.$this->sprache[67].'</button><br>';

                $counter=0;
                if(!is_null($dbresult))
                {
                    foreach($dbresult as $rowa)
                    {
                            echo '<input type="Checkbox" name="artikel" value="'.$counter.'">';
                            echo $this->sprache[68].'<enctext>'.$rowa['termin']['von'].'</enctext> '.$this->sprache[69].'<enctext>'.$rowa['termin']['bis'].'</enctext> '.$this->sprache[70].'<enctext>'.$rowa['termin']['ort'].'</enctext>';
                            echo '<enctext>'.$rowa['termin']['text'].'</enctext><br>'.$this->sprache[71].'<br>';
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
                    echo '<h3>'.$this->sprache[72].'</h3>';
                }
                else 
                {
                    echo '<h3>';
                    if($butt)
                    {
                        echo '<button onclick="termin.zuruck()" >'.$this->sprache[72].'</button>';
                    }
                    echo $this->sprache[73].date('G:i d.m.y',$timea).$this->sprache[74].date('G:i d.m.y',$timeb).' ';
                    if($butt)
                    {
                        echo '<button onclick="termin.vor()" >'.$this->sprache[75].'</button>';
                    }
                    echo '</h3>';
                }
                if(!is_null($dbresult))
                {
                    foreach($dbresult as $rowa)
                    {
                            echo $this->sprache[76].'<enctext>'.$rowa['termin']['von'].'</enctext> '.$this->sprache[77].'<enctext>'.$rowa['termin']['bis'].'</enctext> '.$this->sprache[78].'<enctext>'.$rowa['termin']['ort'].'</enctext>';
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
        .$this->sprache[1].'<input type="hidden"name="angzname" value="'.$werte["angzname"].'"><fehler>'.$fehlerwerte['angzname'].'</fehler><br><br>
        '.$this->sprache[6].'<input type="hidden" name="vname" value="'.$werte["vname"].'"><fehler>'.$fehlerwerte['vname'].'</fehler><br><br>
        '.$this->sprache[2].'<input type="hidden"  name="nname" value="'.$werte["nname"].'"><fehler>'.$fehlerwerte['nname'].'</fehler><br><br>
        '.$this->sprache[79].'<button id="passbutton" onclick="person.aenderePassw()" >'.$this->sprache[79].'</button><br><br>
        '.$this->sprache[3].'<input type="hidden" name="email" value="'.$werte["email"].'"><fehler>'.$fehlerwerte['email'].'</fehler><br><br>
        '.$this->sprache[4].' <input type="hidden" name="str" value="'.$werte["str"].'"><fehler>'.$fehlerwerte['str'].'</fehler><br><br>
        '.$this->sprache[9].'<input type="hidden"  name="ort" value="'.$werte["ort"].'"><fehler>'.$fehlerwerte['ort'].'</fehler><br><br>
        '.$this->sprache[5].'<input type="hidden" name="land" value="'.$werte["land"].'"><fehler>'.$fehlerwerte['land'].'</fehler><br><br>
        <button id="speicherEin" value="Register" onclick="person.speichereEin()" >'.$this->sprache[80].'</button></registerform>';

echo '<form action="?upload" method="post" enctype="multipart/form-data">
        '.$this->sprache[81].'<input type="file" name="datei">
        <input type="submit" value="'.$this->sprache[82].'">
        </form>';
    }
    
    public function aenderP($code) {
        
        echo '<registerform><input type="hidden" name="identifier" value="'.$code.'">';
        $daten='<registerform>'.$this->sprache[83].'<input type="password"  name="code"><br>
                '.$this->sprache[84].'<input type="password"  name="passwt" ><br>
                '.$this->sprache[85].'<input type="password"  name="passwt2" ><br>';
        $datensecend='<button  onclick="person.storeneuesPass()" >'.$this->sprache[86].'</button></registerform>';
 
        echo $daten.$datensecend;

    }
    
    public function vergessen() {
        echo 'Bitte geben sie hier Ihre email an und was sie zum erfolgreichen login brauchen: <br>'
        .'<form >'.$this->sprache[3].' <input  name="email"><br>'
        .'<input type="checkbox" name="user">  neuer Username'
        .'<input type="checkbox" name="pass"> neues Passwort<br>'
        .'<button  id="anfordern" data-dojo-type="dijit/form/Button"  type="submit" >Anfordern</button></form>';
    }
}


