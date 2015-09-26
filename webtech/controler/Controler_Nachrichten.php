<?php
require_once $_SESSION['pfad'].'/model/Nachricht.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen des Nachrichtensaustausches
 */
class Controler_Nachrichten extends Controler {
     
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model= new Nachricht();
        
    }
     
    /**
     * Start der Verarbeitung
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
            domConstruct.place('<em> Nachrichten</em>', greetingNode);});</script>");

    }
        
    /**
     * Operationen des Hauptbereiches
     */
    public function showContent() {
        $this->content->anfang();
        // Nachricht posten
        if(isset($_GET['nachricht']))
        {
            $this->checkHacker($this->decryptit($_POST['nachricht']));
            $txt=  $this->sqlwort;
            $this->checkHacker($this->decryptit($_POST['pinnwand']));
            $this->model->postNachricht($_SESSION['userid'],$this->sqlwort,$_SESSION['freunde'],$txt);
        }
        // Nachrichten anzeigen
        else if(isset($_GET['neuigkeiten']))
        {
            $dbresult=$this->model->getAllNachrichten($_SESSION['userid'],$_SESSION['freunde']);
            $this->content->showNeuigkeiten($this->encryptNachrichten($dbresult));
        }
        else
        {
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->neuenachricht($_SESSION['identifier'],$this->encryptFriendsArray($_SESSION['freunde']));
        }
        $this->content->ende(); 
    }

    /**
     * Operationen des Seitenfußes
     */
    public function showfooter() {
        
        $this->footer->anfang();
        $this->footer->ende();
    }

    /**
     * Operationen am Seitenkopf
     */
    public function showhead() {
        $this->head->show();
        if(isset($_GET['neuigkeiten']))
        {
            $this->head->makerefresh();
        }
        if(isset($_GET['nachrichtneu']) || isset($_GET['neuigkeiten']))
        {
            $javascript='nachricht.decodeNachricht()';
        }
        $this->head->anfang($javascript);
        $this->head->title();
        $this->head->bild($_SESSION['userid']);
        $this->head->ende();
    }

    /**
     * Operationen im linken Menu
     */
    public function showleftbar() {
        
        $this->leftbar->anfang();
        $this->leftbar->normal();
        $this->leftbar->ende();
        
    }

    /**
     * Operationen im rechten Bereich
     */
    public function showrigthbar() {
        $this->rightbar->anfang();
        $this->rightbar->normal();
        $this->rightbar->ende();
    }
    
    /**
     * Verschlüsselung der Freunde
     * @param type $dbresult von der Datenbank
     * @return type $dbresult verschlüsselt
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
    
    /**
     * Versclüsselung der Nachrichten zum Senden
     * @param type $dbresult Aus Datenbank
     * @return type §dbresult verschlüsselt
     */
    public function encryptNachrichten($dbresult) {
        
        if(!is_null($dbresult))
        {
            foreach ($dbresult as $row) {
                $rownew['useridfrom']= $this->encryptit($row['useridfrom']);
                $rownew['message']=  $this->encryptit($row['message']);
                $rownew['datum']=  $this->encryptit(date('H:m m.d.Y',$row['datum']));
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
