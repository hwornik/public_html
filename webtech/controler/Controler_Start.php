<?php
require_once $_SESSION['pfad'].'/controler/Controler.php';
require_once $_SESSION['pfad'].'/controler/Controler_Buch.php';
require_once $_SESSION['pfad'].'/controler/Controler_ImIn.php';
require_once $_SESSION['pfad'].'/controler/Controler_Freunde.php';
require_once $_SESSION['pfad'].'/controler/Controler_Nachrichten.php';
require_once $_SESSION['pfad'].'/controler/Controler_Einstellungen.php';
require_once $_SESSION['pfad'].'/controler/Controler_Termin.php';
require_once $_SESSION['pfad'].'/model/Start.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler steuert die anderen Controler
 */
class Controler_Start extends Controler {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model= new Start();
    }
    
    /**
     * Prüfen ob javascript aktiviert ist
     */
    public function checkJavaScript() {
        
        $weiter='';
        if(isset($_GET['active']))
        {
            $weiter='&active='.$_GET['active'];
        }
        if(isset($_GET['javascript']))
        {
            $_SESSION['javascript']=true;
        }
        else if(!isset($_SESSION['javascript']))
        {
            echo'<script type="text/javascript">
                            self.location.href="?javascript=yes'.$weiter.'"
                        </script>';
            $_SESSION['javascript']=false;
        }
    }
    
    /**
     * Steuert die Auswahl der anderen Controler
     */
    public function start() {
        $this->checkJavaScript();
        // Jabascript aktiviert
        if(!$_SESSION['javascript'])
        {
                if(isset($_SESSION['userid']) && $_SESSION['userid']<1)
                {
                    $this->sessionExit();
                }
                $cntrl=new Controler_Buch();
                $cntrl->start(); 
        }
        else
        {
            // User eingeloggt
            if(isset($_SESSION['userid']) && ($_SESSION['userid']>=1))
            {
                $_SESSION['freunde']=  $this->model->getFreunde($_SESSION['userid']);
                if(isset($_GET['Abmelden']))
                {
                    $this->sessionExit();
                }
                else if(isset($_GET['freunde']) || isset($_GET['showfriends']) || isset($_GET['friendsanfrage']) || isset($_GET['friendsbest']))
                {
                    $cntrl= new Controler_Freunde();
                    $cntrl->start();
                }
                else if(isset($_GET['nachrichtneu']) || isset($_GET['nachricht']) || isset($_GET['neuigkeiten']))
                {
                    $cntrl= new Controler_Nachrichten();
                    $cntrl->start();
                }
                else if(isset($_GET['Termin']) || isset($_GET['termintag']) || isset($_GET['terminbuchen']) || isset($_GET['vor']) || isset($_GET['zuruck']))
                {
                    $cntrl= new Controler_Termin();
                    $cntrl->start();
                }
                else if(isset($_GET['Einstellungen']) || isset($_GET['upload']) || isset($_GET['aendereEin']) || isset($_GET['aenderePas']) || isset($_GET['pasaender']) || isset($_GET['exit'])|| isset($_GET['ende']))
                {
                    $cntrl= new Controler_Einstellungen();
                    $cntrl->start();
                }
                // 
                else
                {
                    $cntrl= new Controler_ImIn();
                    $cntrl->start();
                }
            }
            // für ausgeloggte User
            else 
            {     
                $cntrl= new Controler_Buch();
                $cntrl->start();
            }
        }
    }
    
    public function showContent() {
        
    }

    public function showfooter() {
        
    }

    public function showhead() {
        
    }

    public function showleftbar() {
        
    }

    public function showrigthbar() {
        
    }

}
