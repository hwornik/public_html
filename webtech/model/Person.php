<?php
require_once $_SESSION['pfad'].'/model/Validator.php';
require_once $_SESSION['pfad'].'/model/Model.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Diese Klasse steuert alle Aktionen die auf Personendaten beruhen exklusive Freundschaftsbeziehungen
 */
class Person extends Model {
    
    private $vname;
    private $nname;
    private $passwd;
    private $userid;
    private $nick;
    private $email;
    private $logon;
    private $ort;
    private $land;
    private $strasse;
    private $foto;
    private $activcode;
    private $activlnk;
    private $wertefehler;
    private $challenge;

    
    
    /**
     * Speichert das werte-Array in dieser Klasse
     * @param type $werte
     */
    public function storeRegdata($werte) {
  
            $this->nick=$werte["angzname"];
            $this->vname=$werte["vname"];
            $this->nname=$werte["nname"];
            $this->logon=$werte["logon"];
            $this->email=$werte["email"];
            $this->ort=$werte["ort"];
            $this->strasse=$werte["str"];
            $this->land=$werte["land"];

    }
    
    /**
     * Nickname abrufen
     * @return String
     */
    public function getNick() {
        return $this->nick;
    }
    
    /**
     * Vornamen abrufen
     * @return String
     */
    public function getVorname() {
        return $this->vname;
    }

    /**
     * Nachnamen Abrufen
     * @return String
     */
    public function getNachname() {
        return $this->nname;
    }
    
    /**
     * Logon abrufen
     * @return hashwert
     */
    public function getLogon() {
        return $this->logon;
    }

    /**
     * User Id abrufen
     * @return int
     */
    public function getUserId() {
        return $this->userid;
    }

    /**
     * Fehlerwertearray abrufen
     * @return Array
     */
    public function getWerteFehler() {
        return $this->wertefehler;
    }
    
    /**
     * Passwort abrufen
     * @return hash
     */
    public function getPasswt() {
        return $this->passwd;
    }
    
    /**
     * Email abfragen
     * @return String
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Ort abfragen
     * @return String
     */
    public function getOrt() {
        return $this->ort;
    }
    
    /**
     * Strasse abfragen
     * @return String
     */
    public function getStrasse() {
        return $this->strasse;
    }
    
    /**
     * Land abfragen
     * @return String
     */
    public function getLand() {
        return $this->land;
    }

    /**
     * FotoPfad abrufen
     * @return type
     */
    public function getFoto() {
        return $this->foto;
    }
    
    /**
     * Activierungscode abrufen
     * @return type
     */
    public function getCode() {
        return $this->activcode;
    }

    /**
     * Aktivierungslink abfragen
     * @return String
     */
    public function getLink() {
        return $this->activlnk;
    }
    
    /**
     * Foto pfad setzen
     * @param type $foto
     */
    public function setFoto($foto) {
        $this->foto=$foto;
    }

   /**
    * Passwort setzen
    * @param type $pass
    */
    public function setPasswt($pass) {
        $this->passwd=$pass;
    }

    /**
     * Fehlerwerte setzen
     * @param Array $wert
     */
    public function setWerteFehler($wert) {
        $this->wertefehler=$wert;
    }
    
    /**
     * UserId setzen
     * @param type $id
     */
    public function setUserID($id) {
        $this->userid=$id;
    }
    
    /**
     * Gespeicherte Registrierungswerte testen
     * @param type $email2 zur Verifikation
     * @return boolean  ob in Ordnung
     */
    public function checkReg($email2) {
            $fehler=false;
            $this->validt= new Validator_String();
            if(!$this->validt->check($this->nick))
            {
                $fehler=true;
                $this->wertefehler["angzname"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->logon))
            {
                $fehler=true;
                $this->wertefehler["logon"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->strasse))
            {
                $fehler=true;
                $this->wertefehler["str"]=$this->validt->errorMessage();
            }
            $this->validt= new Validator_Name();
            if(!$this->validt->check($this->ort))
            {
                $fehler=true;
                $this->wertefehler["ort"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->land))
            {
                $fehler=true;
                $this->wertefehler["land"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->vname))
            {
                $fehler=true;
                $this->wertefehler["vname"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->nname))
            {
                $fehler=true;
                $this->wertefehler["nname"]=$this->validt->errorMessage();
            }
            $this->validt= new Validator_Email();
            if(!$this->validt->check($this->email))
            {
                $fehler=true;
                $this->wertefehler["email"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($email2))
            {
                $fehler=true;
                $this->wertefehler["email2"]=$this->validt->errorMessage();
            }
            else 
            {
                if(strcmp($this->email,$email2)!=0)
                {
                    $fehler=true;
                    $this->wertefehler["email2"]='Fehler Email Adressen nicht Identisch';
                }
            }
            return $fehler;

     }
     
     /**
      * User aktivieren und Passwort setzen
      * @param type $code   Aktivierungscode
      * @param type $passwt Passwort hash
      * @return boolean     ob erfolgreich
      */
     public function activateUser($code,$passwt) {
        
        if($this->data->setPersonActvebyCode($code,$passwt))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    /**
     * User Registrieren
     * @param type $werte   Array der Werte
     * @param type $wertef  Array von bereits erkannten Fehlern
     * @return string       Ergebnis der Prüfung und Speicherung
     */
    public function registerUser($werte,$wertef) {

            $this->wertefehler=$wertef;
            $this->storeRegdata($werte);
            if(!$this->checkReg($werte['email2']))
            {
                $this->activcode=$this->zufallsstring(6);
                $this->activlnk=$this->zufallsstring(20);
                $this->passwd="";
                $this->foto='';
                if($this->data->checkEmail($this->email))
                {
                    if($this->data->checkLogon($this->logon))
                    {
                        if(mail($this->email,"Verifikation", 'Bitte benutzen sie diesen link: http://www.wornik.eu/webtech/index.php?active='.$this->activlnk.'  und geben sie folgenden code ein: '.$this->activcode.'  Danke',"From: Terminbuch <hans@wornik.eu>"))
                        {
                            if($this->data->storePerson($this))
                            {
                                $erg='ergebnisokundgespeichert';
                            }
                            else 
                            {
                                $erg='Momentan keine Registrierung möglich';
                            }
                        }
                        else
                        {
                            $erg='Mail konnte nicht verschickt werden, versuchen sie es später wieder';
                        }
                    }
                    else
                    {
                        $this->wertefehler['logon']='Nicht verfügbar';
                        $erg='nichtok';
                    }
                }
                else 
                {
                    $this->wertefehler['logon']='Email bereits registriert';
                    $erg='nichtok';
                }
                
            }
            else 
            {
                $erg='nichtok';
            }
            $wertef=$this->getWerteFehler();
            $wertef['ergebnis']=$erg;
            return $wertef;
        }
        
        /**
         * Test ob User existiert und abspeichern des Passwortes und userId
         * @param type $user    hash logon
         * @return boolean      ob OK
         */
        public function logUser($user) {
            $pers=$this->data->getPasswbyLogon($user);
            if($pers!=null)
            {
                $this->passwd=$pers->getPasswt();
                $this->userid=$pers->getUserId();
                if(strlen($this->passwd)>5)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else 
            {
                return false;
            }
        }
      
    /**
     * Abrufen des Aktivierungscode über link
     * @param type $link    Aktivierungslinkwert
     * @return String       Code
     */
    public function getRegCode($link) {
        return $this->data->getActiveCode($link);
    }
    
    /**
     * Challenge Zahl generieren
     * @return int
     */
    public function getChallengeZahl() {
        
                srand(time());
                return $this->challenge=rand(2000000001,9999999999);
    }
    
    /**
     * Challenge Berechnung
     * @param type $challenge   int
     * @return int ergebnis
     */
    public function compChall($challenge) {
            $divid=intval($challenge/1000000000);
            $teil=pow(10,$divid);
            $zahl1=intval(challenge/$teil);
            $zahl2=$challenge%$teil;
            return $challenge+$zahl2+1;
    }
    
    /**
     * Cookie für User setzen
     * @param type $user    int user logon hash
     * @param type $ende    time() gültigkeitsdauer
     * @return String       Cookie-Wert
     */
    public function setCookie($user,$ende) {
        
        $val= $this->zufallsstring(40);
        $this->data->setCookie($user,$val,$ende);
        return $val;
    }
    
    /**
     * Sucht über Cookie-Wert den user logon hash
     * @param type $cookie
     * @return hash logon
     */
    public function getUserbyCookie($cookie) {
        
        return $this->data->getUserByCookie($cookie);

    }

    /**
     * Personendaten über userid aus DB abfragen
     * @param int $userid
     */ 
    public function getPersonData($userid)  {

        $dbresult=  $this->data->getUserData($userid);
        $this->email=$dbresult['email'];
        $this->land=$dbresult['land'];
        $this->logon=$dbresult['login'];
        $this->nick=$dbresult['nick'];
        $this->nname=$dbresult['nname'];
        $this->ort=$dbresult['ort'];
        $this->strasse=$dbresult['strasse'];
        $this->vname=$dbresult['vname'];
    }
    
    /**
     * Update der UserDaten
     * @param int $userid
     * @param type $werte   Array der Werte
     * @param type $wertef  Array der Fehler
     * @return string       Fehler
     */
    public function updateUser($userid,$werte,$wertef) {

            $this->wertefehler=$wertef;
            $this->storeRegdata($werte);
            $this->userid=$userid;
            if(!$this->checkEinst())
            {
                if($this->data->updatePerson($this))
                {
                    $erg='ergebnisokundgespeichert';
                }
                else 
                {
                    $erg='Momentan keine Registrierung möglich';
                }
            }
            else 
            {
                $erg='Momentan keine Änderung möglich';
            }
            $wertef=$this->getWerteFehler();
            $wertef['ergebnis']=$erg;
            return $wertef;
        }
        
        /**
         * Daten der EinstellungsSeite testen
         * @return boolean ob ok
         */
        public function checkEinst() {
            $fehler=false;
            $this->validt= new Validator_String();
            if(!$this->validt->check($this->nick))
            {
                $fehler=true;
                $this->wertefehler["angzname"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->strasse))
            {
                $fehler=true;
                $this->wertefehler["str"]=$this->validt->errorMessage();
            }
            $this->validt= new Validator_Name();
            if(!$this->validt->check($this->ort))
            {
                $fehler=true;
                $this->wertefehler["ort"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->land))
            {
                $fehler=true;
                $this->wertefehler["land"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->vname))
            {
                $fehler=true;
                $this->wertefehler["vname"]=$this->validt->errorMessage();
            }
            if(!$this->validt->check($this->nname))
            {
                $fehler=true;
                $this->wertefehler["nname"]=$this->validt->errorMessage();
            }
            $this->validt= new Validator_Email();
            if(!$this->validt->check($this->email))
            {
                $fehler=true;
                $this->wertefehler["email"]=$this->validt->errorMessage();
            }
            return $fehler;

     }
     
     /**
      * Passwort ändern
      * @param type $userid     int
      * @param type $passwt     altes Passwort hash
      * @param type $newpasswt  neues Passwort hash
      * @return boolean         ob ok
      */
     public function changePassw($userid,$passwt,$newpasswt)  {
         
         if(strcmp($this->data->getPasswbyId($userid),$passwt)==0)
         {
            return $this->data->changePasswt($userid,$passwt,$newpasswt);
         }
         else
         {
             return false;
         }
         
     }
}