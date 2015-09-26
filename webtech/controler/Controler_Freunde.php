<?php
require_once $_SESSION['pfad'].'/controler/Controler.php';
require_once $_SESSION['pfad'].'/model/Friend.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen zur ermittlung von freunden
 */
class Controler_Freunde extends Controler {
        
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model= new Friend();
    }
     
    /**
     * Starten der Verarbeitung
     */
    public function start()  {
        
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
            domConstruct.place('<em> Freunde</em>', greetingNode);});</script>");
    }
       
    /**
     * Operationen Hauptbereich
     */
    public function showContent() {
        $this->content->anfang();
        // Ergebnis der Freundschaftssuche
        if(isset($_GET['showfriends']))
        {
            if($_SESSION['identifier']==$_POST['identifier'])
            {
                $this->checkHacker($this->decryptit($_POST['search']));
                $_SESSION['dbres']=$this->model->sucheFreunde($this->sqlwort,$_SESSION['userid']);
                if(!is_null($_SESSION['dbres']))
                {
                    $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
                    $this->content->showFriendssearch($_SESSION['identifier'],$this->encryptFriendsArray($_SESSION['dbres']));
                }
                else
                {
                    $this->content->fehler('keine Datensätze gefunden');
                }
            }
            else 
            {
                $this->sessionExit();
            }
        }
        // Freundschaftsanfragen anzeigen
        else if(isset($_GET['friendsanfrage']))
        {
            if($_SESSION['identifier']==$_POST['identifier'])
            {
                $this->checkHacker($this->decryptit($_POST['text']));
                $confirmed=$this->model->storeFriendsAnfrage($_SESSION['userid'],$_SESSION['dbres'], $_POST['friends'],  $this->sqlwort);
                if($confirmend>=0)
                {
                    $confirmed++;
                    $this->content->fehler($confirmend.' Freundschaftsanfrage verschickt');
                }
                else 
                {
                    $this->content->fehler('Fehler bei der Verschickung der Anfragen, bitte versuchen Sie es später nocheinmal');
                }
                
            }
            else
            {
                $this->sessionExit();
            }
        }
        // Freundschaftsanfraen bestättigen
        else if(isset($_GET['friendsbest']))
        {
            if($_SESSION['identifier']==$_POST['identifier'])
            {
                $erg=$this->model->bestaetigeFreunde($_SESSION['userid'], $_SESSION['anfragen'],  $_POST['bestat']);
                if($erg>=0)
                {
                    $this->content->fehler('Habe '.$erg.' Freundschaften bestättigt');
                }
                else {
                    $this->content->fehler('Fehler bei der Bestättigung');
                }
                
            }
        }
        //Standartfunktion
        else 
        { 
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->sucheFreund($_SESSION['identifier'],$this->encryptFriendsArray($this->model->getFreundAnfr($_SESSION['userid'])),$this->encryptFriendsArray($this->model->getFreundGes($_SESSION['userid'])), $this->encryptFriendsArray($_SESSION['freunde']));
            $_SESSION['anfragen']=  $this->model->getFreundAnfrgID();

        } 
        $this->content->ende(); 
    }

    /**
     * Fußbereich
     */
    public function showfooter() {
        
        $this->footer->anfang();
        $this->footer->ende();
    }

    /**
     * Operationen für den Kopfbereich
     */
    public function showhead() {

        $this->head->show();
        $javascript='friends.decryptSearch()';
        $this->head->anfang($javascript);
        $this->head->title();
        $this->head->bild($_SESSION['userid']);
        $this->head->ende();
    }

    /**
     * Operationen für den linken Bereich
     */
    public function showleftbar() {
        
        $this->leftbar->anfang();
        $this->leftbar->normal();
        $this->leftbar->ende();
        
    }

    /**
     * Operationen für den rechten Bereich
     */
    public function showrigthbar() {
        $this->rightbar->anfang();
        $this->rightbar->normal();
        $this->rightbar->ende();
    }
    
    /**
     * verschlüsselung des DBResult für die Freunde zur übergabe an Ausgabe
     * @param type $dbresult
     * @return type
     */
    public function encryptFriendsArray($dbresult) {
        if(!is_null($dbresult))
        {
            foreach ($dbresult as $row) {
                $rownew['nick']=  $this->encryptit($row['nick']);
                $rownew['vname']=  $this->encryptit($row['vname']);
                $rownew['nname']=  $this->encryptit($row['nname']);
                if(isset($row['message']))
                {
                    $rownew['message']=  $this->encryptit($row['message']);
                }
                $dbnew[]=$rownew;
            }
            return $dbnew;
        }
        else 
        {
            return null;
        }
    }
    
  
}
