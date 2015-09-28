<?php
require_once $_SESSION['pfad'].'/controler/Controler.php';
require_once $_SESSION['pfad'].'/model/Person.php';

require_once $_SESSION['pfad'].'/securimage/securimage.php';
require_once $_SESSION['pfad'].'/controler/Aes.php';
require_once $_SESSION['pfad'].'/view/language/'.$_SESSION['language'].'/Buch.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen bis ein User angemeldet ist
 */
class Controler_Buch extends Controler {
   

    private $userid;
    private $txt;
    private $secimage;
    private $werte;
    private $wertefehler;
    private $logcookie;
    private $sprache;


    /**
     * Erstellen der Klassen die verwendet werden
     */
    public function __construct() {
        parent::__construct();
        $language= new Buch();
        $this->sprache=$language->loadSprache();
        $this->userid = -1;
        $this->model= new Person();
        $this->secimage = new Securimage();
    

    }
 
    /**
     * Startet alle Verarbeitungsprozesse
     */
    public function start() {

        if(isset($_GET['check']))
        {
                if(strcmp($_SESSION['setcookie'],'true')==0)
                {
                    $ende=time()+(3600*24*7);
                    $value=  $this->model->setCookie($_SESSION['logon'],$ende);
                    setcookie("terminbuch", $value, $ende);

                }
        }
        $this->showhead();
        $this->showleftbar();
        $this->showContent();
        $this->showrigthbar();
        $this->showfooter();
        print("<script> require([ 
                'dojo/dom',
                'dojo/dom-construct',
                'dojo/fx',
                'dojo/domReady!'
        ], function (dom, domConstruct,fx) {
            var greetingNode = dom.byId('titel');
            domConstruct.place('<em>".$this->sprache[0]."<em>', greetingNode);});</script>");

       }
    /**
     * Führt alle Operationen durch die den Bereich Content verändern
     */
    public function showContent() {
        
        $this->content->anfang();
        // ist Javascript enabled
        if(!$_SESSION['javascript'])
        {
            $this->content->fehler($this->sprache[1]);
            $this->content->normal();
        }
        // Aktivierungscode übertragen
        else if(isset($_GET['active']))
        {
            $this->content->fehler($this->activeCode($_GET['active']));
            
        }
        // Registrierung erfolgreich abgeschlossen
        else if(isset($_GET['userok']))
        {
            $this->content->fehler($this->sprache[2]);
        }
        // Registrierung ausgewählt
        else if(isset($_GET['Register']))
        {
            $this->registerUser();
        }
        //Challenge auswerten und bei korrekter Antwort user freigeben
        else if(isset($_GET['check']))
        {
            if(strcmp($this->decryptit($_POST['chall']),$this->model->compChall($_SESSION['challenge']))==0)
            {
                $_SESSION['userid']=$_SESSION['logid'];
                unset($_SESSION['logon']);
                unset($_SESSION['challenge']);
                unset($_SESSION['logid']);
                print "<script language=\"javascript\">";
                print "window.location = \"?userok\"; ";
                print "</script>";
 
            }
            else 
            {
                unset($_SESSION['challenge']);
                unset($_SESSION['logid']);             
                $this->sessionExit();
                print "<script language=\"javascript\">";
                print "window.location = \"?usernotok\"; ";
                print "</script>";
            }
        }
        // Cookie wurde übertragen
        else if(isset($_GET['checkcookie']))
        {

            if(strcmp($this->decryptit($_POST['chall']),$this->model->compChall($_SESSION['challenge']))==0)
            {
                $_SESSION['userid']=$_SESSION['logid'];
                unset($_SESSION['logon']);
                unset($_SESSION['challenge']);
                unset($_SESSION['logid']);
                print "<script language=\"javascript\">";
                print "window.location = \"?userok\"; ";
                print "</script>";
            }
            else 
            {
                unset($_SESSION['challenge']);
                unset($_SESSION['logid']);
                $this->sessionExit();
                print "<script language=\"javascript\">";
                print "window.location = \"?usernotok\"; ";
                print "</script>";
            }
        }
        // Fehler aufgetreten
        else if(isset($_GET['fehler']))
        {
            $this->content->fehler($this->sprache[3]);
        }
        // Aktivierungscode und Passwort wurde übertragen
        else if(isset($_GET['actconfirm']))
        {
                $checkcode=$this->decryptit($_POST['code']);
                if(strcmp($checkcode,$_SESSION['key'])==0)
                {
                    if($this->model->activateUser($_SESSION['key'],$this->decryptit($_POST['passwt'])))
                    {
                        $this->content->fehler($this->sprache[4]);
                    }
                    else 
                    { 
                        $this->content->fehler($this->sprache[5]);
                    }
                }
                else 
                {
                    $this->content->fehler($this->sprache[6]);
                }
        }
        // Einlogung gestartet über Cookie oder login
        else if(isset($_GET['Challenge']) || (isset($_COOKIE['terminbuch']) && !isset($_SESSION['passwort'])  && $_SESSION['javascript']))
        {
                if(isset($_COOKIE['terminbuch']))
                {
                    
                    $logon=$this->model->getUserbyCookie($_COOKIE['terminbuch']);
                    if(strlen($logon)<2)
                    {
                        setcookie("terminbuch","",time() - 3600);
                        print "<script language=\"javascript\">";
                        print "window.location = \"?nopasswd\"; ";
                        print "</script>";

                    }
                    $this->logcookie=false;
                    $_SESSION['logon']=$logon;
                    $_SESSION['passwort']='ok';
                }
                else 
                {
                    $logon=$_POST['meins'];
                    $_SESSION['logon']=$logon;
                }
                if($this->model->logUser($logon))
                {
                    $_SESSION['key']=$this->model->getPasswt(); 
                    $_SESSION['logid']=  $this->model->getUserId();
                    $_SESSION['challenge']=$this->model->getChallengeZahl();
                    $_SESSION['setcookie']=$_POST['cookie'];
                    $this->content->sendChallenge($this->encryptit($_SESSION['challenge']));
                }
                else 
                {
                    print "<script language=\"javascript\">";
                    print "window.location = \"?usernotok\"; ";
                    print "</script>";
                }
        }
        else if(isset($_GET['lang']))
        {
            $_SESSION['language']=$_GET['lang'];
            echo '<h1>'.$_GET['lang'].'</h1>';
            print "<script language=\"javascript\">";
            print "window.location = \"?\"; ";
            print "</script>";
            
        }
        // sonstiger Aufruf
        else if(isset($_GET['Vergessen']))
        {
              $this->content->vergessen();
         
        }
        else if(isset($_GET['email']))
        {
            if(strlen($_GET['email'])>2)
            {
            if(isset($_GET['user']) && isset($_GET['pass']) )
            {
                echo 'Sie bekommen ihren usernamen und einen code zugeschickt, <br> mit dem sie ein neues Passwort eingeben können';
            }
            else if(isset($_GET['user']))
            {
                echo 'Sie bekommen ihren usernamen zugeschickt';
            }
            else if(isset($_GET['pass']))
            {
                echo 'Sie bekommen einen code zugeschickt, mit dem sie ein neues Passwort eingeben können';
            }
            else
            {
                echo 'Fehler sie haben keine  Aktion ausgwählt';
            }
            }
            else
            {
                echo 'keine gültige emailadresse';
            }
         
        }
        // sonstiger Aufruf
        else
        {
             $this->content->normal();
        }
        $this->content->ende(); 
     }

     /**
     * Führt alle Operationen durch die den Bereich Footer verändern
     */
    public function showfooter() {
        $this->footer->anfang();
        $this->footer->ende();
        $this->toolTips();
    }

    /**
     * Führt alle Operationen durch die den Bereich Header verändern
     */
    public function showhead() {

            $this->head->show();
            // decrypt
            $jscriptfunc="";
            if(isset($_GET['Register']))
            {
                $jscriptfunc="person.getKeyafillformReg()";
   
            }
            // verarbeite Challenge
            if(isset($_GET['Challenge']))
            {
                $jscriptfunc="person.compChallenge()";
        
            }
            // verarbeite Challenge über Cookie
            else if(isset($_COOKIE['terminbuch']) && $_SESSION['javascript'])
            {
                $jscriptfunc="person.compChallengeCookie()";

            }
            $this->head->anfang($jscriptfunc);
            $this->head->title();
            // Zeige Login Feld
            if(!isset($_GET['Challenge']) &&  (isset($_SESSION['passwort']) || !isset($_COOKIE['terminbuch'])))
            {
                $this->head->login(); 
            }
            $this->head->ende();
    }

    /**
     * Führt alle Operationen durch die den Bereich leftbar verändern
     */
    public function showleftbar() {
        $this->leftbar->anfang();
        $this->leftbar->normal();
        $this->leftbar->ende();
    }


    /**
     * Führt alle Operationen durch die den Bereich rightbar verändern
     */
    public function showrigthbar() {
        $this->rightbar->anfang();
        $this->rightbar->normal();
        $this->rightbar->ende();
     }
    
    /**
     * User Registrierungssteuerung
     */
    private function registerUser() {
                $this->werte["angzname"]="";
                $this->werte["vname"]="";
                $this->werte["nname"]="";
                $this->werte["logon"]="";
                $this->werte["email"]="";
                $this->werte["email2"]="";
                $this->werte["ort"]="";
                $this->werte["str"]="";
                $this->werte["land"] ="";
                $this->werte["identifier"]="";
            $captchares='';
            // Chaptca übertragen = 2.Aufruf
            if(isset($_POST['captcha_code']))
            {
                $this->werte=$this->decodeReg();
                // stimmen die übertragenen Daten key und identifier
                if((strcmp($this->werte['key'],$_SESSION['key'])==0) && (strcmp($this->werte['identifier'],$_SESSION['identifier'])==0))
                {
                    // überprüfen nach tags und komment
                    if(!$this->checkandStoreReg())
                    {
                        // stimmt captcha nicht
                        if($this->secimage->check($_POST['captcha_code']) == false)
                        { 
                            $captchares='Falsche Eingabe';
                        }
                        else 
                        {
                            //übergabe an Model
                            $this->wertefehler=$this->model->registerUser($this->werte,$this->wertefehler);
                            // keine Fehler aufgetreten?
                            if(strcmp($this->wertefehler['ergebnis'],'ergebnisokundgespeichert')==0)
                            {
                                print "<script language=\"javascript\">";
                                print "window.location = \"?userok\"; ";
                                print "</script>";

                            }

                        }
                    }
                }
                // sonst session zerstören
                else 
                {
                    $this->sessionExit();
                }

            }
            // Ausgabe Registrierungsseite
            $_SESSION['key']=  $this->model->zufallsstring(20);
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->register($_SESSION['identifier'],$_SESSION['key'],$this->getRegWerte(),$captchares, $this->wertefehler);
    }
    
    
     /**
      * testergebnis auslesen  
      */
     private function getTestergebnis() {
         return $this->testergebnis;
     }
     
     /**
      * Eingaben überprüfen auf Tags und SQL comments
      * @return boolean in Ordnung
      * Ergebnisse werden in $this->wertwefehler und $this->werte eingetragen
      */
     private function checkandStoreReg() {
            $fehler=false;
            if(!$this->checkHacker($this->werte['angzname']))
            {
                $fehler=true;
            }
            $this->werte["angzname"]= $this->sqlwort;
            $this->wertefehler["angzname"]=  $this->getTestergebnis(); 
            if(!$this->checkHacker($this->werte['vname']))
            {
                $fehler=true;
            }
            $this->werte["vname"]= $this->sqlwort;
            $this->wertefehler["vname"]=  $this->getTestergebnis();
            if(!$this->checkHacker($this->werte['nname']))
            {
                $fehler=true;
            }
            $this->werte["nname"]= $this->sqlwort;
            $this->wertefehler["nname"]=  $this->getTestergebnis(); 
            if(!$this->checkHacker($this->werte['logon']))
            {
                $fehler=true;
            }
            $this->werte["logon"]= $this->sqlwort;
            $this->wertefehler["logon"]=  $this->getTestergebnis(); 
            if(!$this->checkHacker($this->werte['email']))
            {
                $fehler=true;
            }
            $this->werte["email"]= $this->sqlwort;
            $this->wertefehler["email"]=  $this->getTestergebnis();
            if(!$this->checkHacker($this->werte['email2']))
            {
                $fehler=true;
            }
            $this->werte["email2"]= $this->sqlwort;
            $this->wertefehler["email2"]=  $this->getTestergebnis();
            if(!$this->checkHacker($this->werte['ort']))
            {
                $fehler=true;
            }
            $this->werte["ort"]= $this->sqlwort;
            $this->wertefehler["ort"]=  $this->getTestergebnis();
            if(!$this->checkHacker($this->werte['str']))
            {
                $fehler=true;
            }
            $this->werte["str"]= $this->sqlwort;
            $this->wertefehler["str"]=  $this->getTestergebnis();
            if(!$this->checkHacker($this->werte['land']))
            {
                $fehler=true;
            }
            $this->werte["land"]= $this->sqlwort;
            $this->wertefehler["land"]=  $this->getTestergebnis();
            return $fehler;
     }
     
     /**
      * Verschlüsseln der Daten der Registrierung in werte
      * @return type WerteArray
      */
     public function getRegWerte() {
    
                $this->werte["angzname"]= $this->encryptit($this->werte['angzname']);
                $this->werte["vname"]= $this->encryptit($this->werte['vname']);
                $this->werte["nname"]= $this->encryptit($this->werte['nname']);
                $this->werte["logon"]= $this->encryptit($this->werte['logon']);
                $this->werte["email"]= $this->encryptit($this->werte['email']);
                $this->werte["email2"]= $this->encryptit($this->werte['email2']);
                $this->werte["ort"]= $this->encryptit($this->werte['ort']);
                $this->werte["str"]= $this->encryptit($this->werte['str']);
                $this->werte["land"]= $this->encryptit($this->werte['land']);
                $this->werte["identifier"]= $this->encryptit($this->werte['identifier']);

         return $this->werte;
     }
     
     /**
      * Enztschlüsseln der mit POST übertragenen Werte der Registrierung
      * @return type werteArray
      */
     private function decodeReg() {

            $this->werte["angzname"]=rtrim( $this->decryptit($_POST['angzname']));
            $this->werte["vname"]= rtrim($this->decryptit($_POST['vname']));
            $this->werte["nname"]= rtrim($this->decryptit($_POST['nname']));
            $this->werte["logon"]= $_POST['logon'];
            $this->werte["email"]= rtrim($this->decryptit($_POST['email']));
            $this->werte["email2"]= rtrim($this->decryptit($_POST['email2']));
            $this->werte["ort"]= rtrim($this->decryptit($_POST['ort']));
            $this->werte["str"]= rtrim($this->decryptit($_POST['str']));
            $this->werte["land"]= rtrim($this->decryptit($_POST['land']));
            $this->werte["identifier"]= $_POST['identifier'];
            $this->werte['key']= rtrim($this->decryptit($_POST['key']));
             return $this->werte;
     }
     
     /**
      * prüfen des $code-Aktivierungslink und Abfrage des Codes
      * @param type $code
      * @return string
      */
     public function activeCode($code) {

            if($this->checkHacker($code))
            {
                $_SESSION['key']=  $this->model->getRegCode($this->sqlwort);
                if(is_null($_SESSION['key']))
                {
                    return 'ungültiger Link';
                }
                else 
                {
                    return $this->content->regLogon($_SESSION['javascript']);
                }
            }
            else 
            {
                return $this->wertefehler;

            }
     }
     
     public function toolTips() {
        print('<script>require(["dijit/Tooltip", "dojo/domReady!"], function(Tooltip){
                new Tooltip({
                    connectId: ["Homelink"],
                    label: "'.$this->sprache[7].'"
                });
                new Tooltip({
                    connectId: ["Neuigklink"],
                    label: "'.$this->sprache[8].'"
                });
                new Tooltip({
                    connectId: ["Freundelink"],
                    label: "'.$this->sprache[9].'"
                });
                new Tooltip({
                    connectId: ["Nachrichtlink"],
                    label: "'.$this->sprache[10].'"
                });
                new Tooltip({
                    connectId: ["checkit"],
                    label: "'.$this->sprache[12].'"
                });
                 new Tooltip({
                    connectId: ["neuterminlink"],
                    label: "'.$this->sprache[13].'"
                });
                new Tooltip({
                    connectId: ["terminbestlink"],
                    label: "'.$this->sprache[14].'"
                });
                new Tooltip({
                    connectId: ["terminheutelink"],
                    label: "'.$this->sprache[15].'"
                });
                new Tooltip({
                    connectId: ["terminmorgenlink"],
                    label: "'.$this->sprache[16].'"
                });
                new Tooltip({
                    connectId: ["terminwochelink"],
                    label: "'.$this->sprache[17].'"
                });
                new Tooltip({
                    connectId: ["terminmonatlink"],
                    label: "'.$this->sprache[18].'"
                });
                new Tooltip({
                    connectId: ["terminallelink"],
                    label: "'.$this->sprache[19].'"
                });
            });</script>');
     }
       
   
 }
