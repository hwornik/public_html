<?php
/**
 * Description of Controller
 *
 * @author hans
 */
require_once $_SESSION['pfad'].'/model/Clients.php';
require_once $_SESSION['pfad'].'/view/center.php';
require_once $_SESSION['pfad'].'/view/footer.php';
require_once $_SESSION['pfad'].'/view/navbar.php';
require_once $_SESSION['pfad'].'/view/sidebar.php';
require_once $_SESSION['pfad'].'/view/header.php';

class Controller {
    
    private $head;
    private $leftbar;
    private $content;
    private $rightbar;
    private $footer;
    
    public function __construct() {
        
     $this->head=new Header();
     $this->content= new Center();
     $this->footer= new Footer();
     $this->leftbar= new Navbar();
     $this->rightbar= new Sidebar();
    } 
    
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
    
    public function showHeader() {
        $this->head->show();
    }
    
    public function showNavbar() {
        $this->leftbar->show();
    }
    
    public function showCenter() {
        $this->content->show();
    }
    
    public function showSidebar() {
        $this->rightbar->show();
    }
    
    public function showfooter() {
        $this->footer->show();
    }

}
?>
