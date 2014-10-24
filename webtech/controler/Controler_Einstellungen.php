<?php
require_once $_SESSION['pfad'].'/controler/Controler.php';
require_once $_SESSION['pfad'].'/model/Person.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert die änderungen in den Einstellungen
 */
class Controler_Einstellungen extends Controler {
   
    private $werte;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model= new Person();
     }
     
    /**
     * Starten der Verarbeitungsschritte
     */
    public function start()  {
        
        $this->showhead();
        $this->showleftbar();
        $this->showContent();
        $this->showrigthbar();
        $this->showfooter();

    }
       
    /**
     * Alle Operationen die den Hauptbereich verändern
     */
    public function showContent() {
        $this->content->anfang();
        // Bild wurde zur übertragung eingegeben
        if(isset($_GET['upload']))
        {
            $this->uploadBild();
            $this->model->getPersonData($_SESSION['userid']);
            $this->getEinWertevPerson();
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->einstellungen($_SESSION['identifier'],$this->werte,$fehlerwerte) ;
        }
        //Einstellungen wurden geändert
        else if(isset($_GET['aendereEin']))
        {
       
            $this->decodeEinWerte();
            $this->wertefehler=$this->model->updateUser($_SESSION['userid'],  $this->werte, $fehlerwerte);
            if(strcmp($this->wertefehler['ergebnis'],'ergebnisokundgespeichert')==0)
            {
                $this->content->fehler('Einstellungen upgedated');
            }
            else 
            {
                 $this->encodeWerte();
                 $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
                 $this->content->einstellungen($_SESSION['identifier'],$this->werte,$this->wertefehler) ;
            }
        }
        // Änderung des Passwortes
        else if(isset($_GET['aenderePas']))
        {
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->aenderP($_SESSION['identifier']);
                    
        }
        // Prüfen der Passwortänderungen
        else if(isset($_GET['pasaender']))
        {
            $this->checkHacker($this->decryptit($_POST['oldpw']));
            $old=  $this->sqlwort;
            $this->checkHacker($this->decryptit($_POST['newdpw']));
            $new=  $this->sqlwort;
            if($this->model->changePassw($_SESSION['userid'],$old,$new))
            {
                $this->content->fehler('Neues Passwort gespeichert, sie werden ausgelogt');
                print "<script language=\"javascript\">";
                print "window.location = \"?exit\"; ";
                print "</script>";

            }
            else 
            {
                $this->content->fehler('Neues Passwort konnte nicht gespeichert werden');
            }
        }
        // ausloggen da es eine Passwortänderungen gibt
        else if(isset($_GET['ende']))
        {

                        $this->sessionExit();
        }
        // Standartausgabe
        else
        {
            $this->model->getPersonData($_SESSION['userid']);
            $this->getEinWertevPerson();
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->einstellungen($_SESSION['identifier'],$this->werte,$fehlerwerte) ;
        }
        
        $this->content->ende(); 
    }

    /**
     * Operationen für den Fussbereich
     */
    public function showfooter() {
        
        $this->footer->anfang();
        $this->footer->ende();
    }

    /**
     * Funktionen für den Kopfbereich
     */
    public function showhead() {

        $this->head->show();
        // logout ankündigen
        if(isset($_GET['exit']))
        {
            $javascript='person.logout()';
        }
        // Standartentschlüsselung
        else 
        {
            $javascript='person.decryptEinstellungen()';
        }
        $this->head->anfang($javascript);
        $this->head->title();
        $this->head->bild($_SESSION['userid']);
        $this->head->ende();
    }

    /**
     * Funktionen für die linke Seite
     */
    public function showleftbar() {
        
        $this->leftbar->anfang();
        $this->leftbar->normal();
        $this->leftbar->ende();
        
    }

    /**
     * Funktionen für die rechte Seite
     */
    public function showrigthbar() {
        $this->rightbar->anfang();
        $this->rightbar->normal();
        $this->rightbar->ende();
    }
    
    /**
     * 
     * @return string Ergebnis der Aktion 
     */
    public function uploadBild() {

        if($_FILES['datei']['tmp_name'].length>1)
        {
            $dateityp = GetImageSize($_FILES['datei']['tmp_name']);

            if($dateityp[2] != 0)
            {
                if($_FILES['datei']['size'] <  102400)
                {
                    move_uploaded_file($_FILES['datei']['tmp_name'], $_SESSION['pfad']."/bilder/".$_SESSION['userid'].'.gif');
                    return  "Das Bild wurde Erfolgreich nach ".$_SESSION['pfad']."/bilder/".$_SESSION['userid']." hochgeladen".$_FILES['datei']['type'] ;
                }
                else
                {
                   return "Das Bild darf nicht größer als 100 kb sein ";
                }

            }
            else
            {
                return "Bitte nur Bilder im Gif bzw. jpg Format hochladen";
            }
        }
    }
    
    /**
     * Verschlüsselung der Daten aus der Datenbank zur Übertragung
     * @return type
     */
    public function getEinWertevPerson() {
    
        $this->werte["angzname"]= $this->encryptit($this->model->getNick());
        $this->werte["vname"]= $this->encryptit($this->model->getVorname());
        $this->werte["nname"]= $this->encryptit($this->model->getNachname());
        $this->werte["logon"]= $this->encryptit($this->model->getLogon());
        $this->werte["email"]= $this->encryptit($this->model->getEmail());
        $this->werte["ort"]= $this->encryptit($this->model->getOrt());
        $this->werte["str"]= $this->encryptit($this->model->getStrasse());
        $this->werte["land"]= $this->encryptit($this->model->getLand());
        return $this->werte;
     }
     
     /**
      * Decodierung der übertragenen Daten und test auf tags und comments
      * @return type wertearray im klartext
      */
     public function decodeEinWerte() {
        $this->checkHacker($this->decryptit($_POST['angzname']));
        $this->werte["angzname"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['vname']));
        $this->werte["vname"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['nname']));
        $this->werte["nname"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['logon']));
        $this->werte["logon"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['email']));
        $this->werte["email"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['ort']));
        $this->werte["ort"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['str']));
        $this->werte["str"]= $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['land']));
        $this->werte["land"]= $this->sqlwort;
         return $this->werte;
 
         }
         
         /**
          * Verschlüsselung der zu übertragenden Daten in werte Array
          * @return type wertearray verschlüsselt
          */
         public function encodeWerte()  {
    
                $this->werte["angzname"]= $this->encryptit($this->werte['angzname']);
                $this->werte["vname"]= $this->encryptit($this->werte['vname']);
                $this->werte["nname"]= $this->encryptit($this->werte['nname']);
                $this->werte["email"]= $this->encryptit($this->werte['email']);
                $this->werte["ort"]= $this->encryptit($this->werte['ort']);
                $this->werte["str"]= $this->encryptit($this->werte['str']);
                $this->werte["land"]= $this->encryptit($this->werte['land']);

                return $this->werte;
         }
}
