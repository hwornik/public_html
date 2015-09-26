<?php
require_once $_SESSION['pfad'].'/view/content.php';
require_once $_SESSION['pfad'].'/view/footer.php';
require_once $_SESSION['pfad'].'/view/head.php';
require_once $_SESSION['pfad'].'/view/leftbar.php';
require_once $_SESSION['pfad'].'/view/rightbar.php';
require_once $_SESSION['pfad'].'/controler/Aes.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Controler Vorgabe mit übergeordneten Funtkionen
 */
abstract class Controler {

    protected $head;
    protected $leftbar;
    protected $content;
    protected $rightbar;
    protected $footer;
    protected $model;
    protected $sqlwort;
    protected $testergebnis;
    
    /**
     * Erstellung aller Verknüpfungen
     */
    public function __construct() {

        $this->head=new Head();
        $this->content= new Content();
        $this->footer= new Footer();
        $this->leftbar= new Leftbar();
        $this->rightbar= new Rightbar();
  
        }
    
    /**
     * vorgabe für den Kopfbereich
     */
    abstract public function showhead();

    /**
     * Vorgabe für den linken Bereich
     */
    abstract public function showleftbar();

    /**
     * Vorgabe für den Hauptbereich
     */
    abstract public function showContent();

    /**
     * Vorgabe für die rechte Seite
     */
    abstract public function showrigthbar();

    /**
     * Vorgabe für den unteren Bereich
     */
    abstract public function showfooter();
             

    /**
     * Verschlüsseln von Daten am Server
     * @param String $data    zu Verschlüsselnde Daten
     * @return Hex-Code       mit dem in $key gespeicherten String mit DES verschlüsselten Daten von $data
     */
    public function encryptit($data)
    {    

         if(strlen($data)>1)
        {
             return AesCtr::encrypt($data,$_SESSION['key'], 256);  
        }

    }
    
    /**
     * Entschlüsseln von Daten am Server
     * @param Hex-Code $data    zu Entschlüsselnde Daten in Hex-Code
     * @return String           mit dem in $key gespeicherten Schlüssel entschlüsselte Daten             
     */
    public function decryptit($data) {
 
        if(strlen($data)>1)
        {
            return AesCtr::decrypt($data,$_SESSION['key'], 256);
        }

    }
    
    /**
     * Entfernt Tags html,php tags und die Kommentarbefehle von Sql
     * @param type $codein  zu testende Variable
     * @return boolean  ob keine Fehler gefunen wurden->sqlwort Variable
     * Ergebnisse stehen in $this->testergebnis Fehlerart und $this-
     */
    public function checkHacker($codein) {

        $code=strip_tags($codein);
        $codei = str_replace(";","",$code);
        $codeii = str_replace("--","",$codei);
        $this->sqlwort=$codeii;
        if(strlen($codein)==strlen($codeii))
        {
            if(strlen($code)>0)
            {
                $this->testergebnis="";
                return true;

            }
            else 
            {
                            $this->testergebnis="Eingabe erforderlich";
                            return false;
            }
        }
        else
        {
            $this->testergebnis="Ungültiges Zeichen entfernt";
            return false;
        }
    }
    
    /**
     * Session beenden und cookie löschen
     */
    public function sessionExit() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) 
        {
                $params = session_get_cookie_params();
                //setcookie(session_name(), '', time() - 42000, $params["path"],$params["domain"], $params["secure"], $params["httponly"]);
        }
        session_unset();
        session_destroy();
        setcookie ("terminbuch", "", time() - 3600);

        print "<script language=\"javascript\">";
        print "window.location = \"?\"; ";
        print "</script>";
     }
     
  
}
