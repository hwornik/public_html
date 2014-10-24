<?php
require_once $_SESSION['pfad'].'/model/Termin.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert alle Aktionen bis ein User angemeldet ist
 */
class Controler_Termin extends Controler {
      
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model= new Termin();
    }
     
    /**
     * Start der Operationen
     */
    public function start()  {
        
        $this->showhead();
        $this->showleftbar();
        $this->showContent();
        $this->showrigthbar();
        $this->showfooter();
    }
            
    /**
     * Hauptfenstersteuerung
     */
    public function showContent() {
        $this->content->anfang();
        // Termin erstellen
        if(isset($_GET['terminneu']))
        {
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->neuerTermin($_SESSION['identifier'],$this->encryptFriendsArray($_SESSION['freunde']));
        }
        // Termintag Zeiten abfragen und mit Freundauswahl
        else if(isset($_GET['termintag']))
        {
            $termindate=  $this->decryptTagDate();
            $_SESSION['terminFr']=$this->model->getTeilnehmerZeit($_SESSION['userid'],$termindate,$_SESSION['freunde']);
            $_SESSION['termin']=mktime(0,0,0,$termindate['monat']+1,$termindate['tag'],$termindate['jahr']);
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->selectTermin($_SESSION['identifier'],$_SESSION['termin'],  $this->encryptSelectTer($_SESSION['terminFr']));       
        }
        //Termin fixieren
        else if(isset($_GET['terminbuchen']))
        {
            
            $this->checkHacker($this->decryptit($_POST['anfang']));
            $von=$this->sqlwort;
            $this->checkHacker($this->decryptit($_POST['ende']));
            $bis=$this->sqlwort;
            $this->checkHacker($this->decryptit($_POST['text']));
            $text=$this->sqlwort;
            //$this->checkHacker($this->decryptit($_POST['bem']));
            //$bem=$this->sqlwort;
            if($this->model->bucheTermin($_SESSION['termin'],$_SESSION['terminFr'],$_SESSION['userid'],$von,$bis,$text,' '))
            {
                $this->content->fehler('Termin gebucht');
            }
            else 
            {
                $this->content->fehler('Termin konnte nicht gebucht werden, versuchen sie es später wieder');
            }
        }     
        // offene Termine bestätigen
        else if(isset($_GET['bestatigen']))
        {
            $_SESSION['dbresult']=$this->model->getoffeneTermine($_SESSION['userid']);
            $_SESSION['identifier']=hash("sha256",$this->model->zufallsstring(20));
            $this->content->showOffeneTermine($_SESSION['identifier'],$this->encryptOffeneTermine($_SESSION['dbresult']));
        }
        // Termin annehmen
        else if(isset($_GET['terminannehmen']))
        {

            if($this->model->setTerminOk($_SESSION['userid'],$_SESSION['dbresult'],$_POST['nummer'], 'b'))
            {
                $this->content->fehler('Termin bestätigt');
            }
            else 
            {
                $this->content->fehler('Termin konnte nicht bestötigt werden, versuchen sie es später wieder');
            }
        }
        // Termin ablehen
        else if(isset($_GET['terminablehnen']))
        {
            if($this->model->setTerminOk($_SESSION['userid'],$_SESSION['dbresult'],$_POST['nummer'],  $this->decryptit($_POST['bemerk']),'a'))
            {
                $this->content->fehler('Termin abgelehnt');
            }
            else 
            {
                $this->content->fehler('Termin konnte nicht abgelehnt werden, versuchen sie es später wieder');
            }
            
        }
        // Zeige alle Termine
        else if(isset($_GET['alle']))
        {
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],0,0,false);
            $this->content->showTermine(0,0,$this->encryptOffeneTermine($dbresult),false);
        }
        // Zeige alle Termine von heute +30Tage
        else if(isset($_GET['monat']))
        {
            $uhrzeit = date("H:i"); 
            $teile = explode(':', $uhrzeit); 
            $corra=$teile[0]*60*60+$teile[1]*60;
            $von=time()-$corra;
            $bis=$von+30*24*60*60;
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],$von,$bis);
            $this->content->showTermine($von, $bis,$this->encryptOffeneTermine($dbresult),false);
        }  
        // Zeige die Termine von dieser Woche
        else if(isset($_GET['woche']))
        {
            $_SESSION['von']=strtotime('last Sunday', time());
            $bis=$_SESSION['von']+7*24*60*60;
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],$_SESSION['von'],$bis);
            $this->content->showTermine($_SESSION['von'],$bis,$this->encryptOffeneTermine($dbresult),true);
        }
        // Zeige die Wochenermine eine Woche vorwärts
        else if(isset($_GET['vor']))
        {
            $shift=7*24*60*60;
            $_SESSION['von']=$_SESSION['von']+$shift;
            $bis=$_SESSION['von']+$shift;
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],$_SESSION['von'],$bis);
            $this->content->showTermine($_SESSION['von'],$bis,$this->encryptOffeneTermine($dbresult),true);
        }
        // Zeige die Wochentermine eine Woche zurück
        else if(isset($_GET['zuruck']))
        {
            $shift=7*24*60*60;
            $_SESSION['von']=$_SESSION['von']-$shift;
            $bis=$_SESSION['von']+$shift;
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],$_SESSION['von'],$bis);
            $this->content->showTermine($_SESSION['von'],$bis,$this->encryptOffeneTermine($dbresult),true);
        }
        // Zeige die Termine von heute
        else if(isset($_GET['heute']))
        {
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],strtotime('today', time()),strtotime('today', time())*24*60*60);
            $this->content->showTermine(strtotime('today', time()),strtotime('today', time()+23*60*60),$this->encryptOffeneTermine($dbresult),false);
        }
        // Zeige die Termine von Morgen
        else if(isset($_GET['morgen']))
        {
            $dbresult=  $this->model->getbestTermine($_SESSION['userid'],strtotime('today', time()+24*60*60),strtotime('today', time())+2*24*60*60);
            $this->content->showTermine(strtotime('today', time()+24*60*60),strtotime('today', time()+2*24*60*60),$this->encryptOffeneTermine($dbresult),false);
        }
        // Standartausgabe
        else   
        {
            $this->content->normal();
        }
        $this->content->ende(); 
    }

    /**
     * Operationen für Footer
     */
    public function showfooter() {
        
        $this->footer->anfang();
        $this->footer->ende();
    }

    /**
     * Operationen die änderungen im Kopf erforden
     */
    public function showhead() {
        $this->head->show();
        // encrypt und setze heutigen Tag
        if(isset($_GET['terminneu']))
        {
            $javascript='termin.setDate()';
        }
        // ebcrypt gezeigten Text
        else 
        {
            $javascript='termin.decSelect()';
        }
        $this->head->anfang($javascript);
        $this->head->title();
        $this->head->bild($_SESSION['userid']);
        $this->head->ende();
    }

    /**
     * Operationen die linke Seite betreffen
     */
    public function showleftbar() {
        
        $this->leftbar->anfang();
        $this->leftbar->normal();
        $this->leftbar->ende();
        
    }

    /**
     * Operationen die rechte Seite betreffen
     */
    public function showrigthbar() {
        $this->rightbar->anfang();
        $this->rightbar->normal();
        $this->rightbar->ende();
    }
    
    /**
     * Verschlüseseln der Freunde zur Ausgabe
     * @param type $dbresult
     * @return type $db encrypted
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
     * Entschlüsseln und testen der Termindaten
     * @return type Array entschlüsselt
     */
    private function decryptTagDate() {
        

        $rownew['teilnehmer']=$_POST['teilnehmer'];
        $this->checkHacker($this->decryptit($_POST['monat']));
        $rownew['monat']=  $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['tag']));
        $rownew['tag']=  $this->sqlwort;
        $this->checkHacker($this->decryptit($_POST['jahr']));
        $rownew['jahr']=  $this->sqlwort;
        $this->checkHacker($_POST['offen']);
        $rownew['offen']=  $this->sqlwort;
        return $rownew;
    }
    
    /**
     * Verschlüsseln der Freundesdaten mit Termindaten
     * @param type $terminFr
     * @return type Array verschlüsselt für Ausgabe
     */
    private function encryptSelectTer($terminFr) {
        if(!is_null($terminFr))
        {
            foreach ($terminFr as $row) {
                $rowd['freundname']=$this->encryptit($row['freundname']);
                $rowd['werte']=$this->encryptit($row['werte']);  
                $term[]=$rowd;
            }
            return $term;
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Verschlüsseln und Aufbereitung der Termindaten
     * @param type $dbresult
     * @return type §dbresult verschlüsselt
     */
    private function encryptOffeneTermine($dbresult) {
        if(!is_null($dbresult))
        {
            foreach($dbresult as $rowa)
            {
                    $rowdt=null;
                    $rowdtt['von']=  $this->encryptit(date('G:i d.m.y',$rowa['termin']['von']));
                    $rowdtt['bis']= $this->encryptit(date('G:i d.m.y',$rowa['termin']['bis']));
                    $rowdtt['ort']= $this->encryptit($rowa['termin']['ort']);
                    $rowdtt['text']= $this->encryptit($rowa['termin']['text']);
                    $rowdt['termin']= $rowdtt;
                    $rowun=null;
                    if(!is_null($rowa['user']))
                    {
                        foreach($rowa['user'] as $rowu)
                        {
                            $rownew=null;
                            $rownew['vname']=$this->encryptit($rowu['vname']);
                            $rownew['nname']=$this->encryptit($rowu['nname']);
                            if(!(strpos($rowu['nimtteil'],"o")===false))
                            {
                                $rownew['nimtteil']=', nicht bestätigt';
                            }
                            if(!(strpos($rowu['nimtteil'],'b')===false))
                            {
                                $rownew['nimtteil']=', bestätigt';
                            }
                            $rownew['grund']=$this->encryptit($rowu['grund']);
                            $rowun[]=$rownew;
                        }
                        $rowdt['user']=$rowun;
                    }
                    $result[]=$rowdt;
            }
            return $result;
        }
        else 
        {
            return null;
        }
    }
}
