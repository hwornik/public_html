<?php
/**
 * Description of Controller
 *
 * @author hans
 */
require_once $_SESSION['pfad'].'/Model/Clients.php';
class Controller {
    
    public function init () {
            
            $test = new Clients();
            $sys = $test->getSystem();
            if(!isset($_SESSION['system'] ))
            {
                $_SESSION['system'] = $sys['system'];
            }
            if(!isset($_SESSION['browser'] ))
            {
                $_SESSION['browser'] = $sys['name'];
            }
            return;
    }

    public function getText() {
        $action=$_GET['action'];
        $seite = implode(" ",file($_SESSION['pfad']."/Model/start.txt")); 
        if($action=='sport')
        {
            $seite = implode(" ",file($_SESSION['pfad']."/Model/sport.txt"));
        }
        if($action=='games1')
        {
            $seite = implode(" ",file($_SESSION['pfad']."/Model/games1.txt"));
        }
        if($action=='chronik1')
        {
            $seite = implode(" ",file($_SESSION['pfad']."/Model/chronik1.txt"));
        }
        if($action=='training')
        {
            $seite = implode(" ",file($_SESSION['pfad']."/Model/training.txt"));
        }
        if($action=='trchronik')
        {
            $seite = implode(" ",file($_SESSION['pfad']."/Model/trchronik.txt"));
        }
        if($action=='tool1')
        {
            $seite = implode(" ",file($_SESSION['pfad']."/Model/tools1.txt"));
        }
        $seite=preg_replace("/[ ]+/" , " " ,$seite);
        return preg_replace("/[^a-zA-Z0-9äöüÄÖÜ_ß <>\/=\":\.?&()\-,]/" , "" ,$seite);
    }
    
}
       


?>
