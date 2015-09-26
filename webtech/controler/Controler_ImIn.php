<?php
require_once $_SESSION['pfad'].'/controler/Controler.php';
require_once $_SESSION['pfad'].'/model/Person.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Controler ist der Default Controler für den eingeloggten User
 */
class Controler_ImIn extends Controler {
    
    /**
     * Constructor
     */
    public function __construct() {
        
        parent::__construct();
        $this->model= new Person();
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
            domConstruct.place('<em> Willkommen</em>', greetingNode);});</script>");
    }
            
    /**
     * Operationen des Hauptbereiches
     */
    public function showContent() {

        $this->content->anfang();
        $this->content->normal();
        $this->content->ende();
    }

    /**
     * Operationen des Fußbereiches
     */
    public function showfooter() {
        
        $this->footer->anfang();
        $this->footer->ende();
    }

    /**
     * Operationen des Kopfbereiches
     */
    public function showhead() {
        $this->head->show();
        $this->head->anfang('');
        $this->head->title();
        $this->head->bild($_SESSION['userid']);
        $this->head->ende();
    }

    /**
     * Operationen des linken Bereiches
     */
    public function showleftbar() {
        
        $this->leftbar->anfang();
        $this->leftbar->normal();
        $this->leftbar->ende();
        
    }

    /**
     * Operationen des rechten Bereiches
     */
    public function showrigthbar() {
        $this->rightbar->anfang();
        $this->rightbar->normal();
        $this->rightbar->ende();
    }

}
