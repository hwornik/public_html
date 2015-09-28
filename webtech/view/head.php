<?php
require_once $_SESSION['pfad'].'/view/language/'.$_SESSION['language'].'/Headlang.php';
class Head {
    
    private $sprache;
    
    public function show() {
        $lang= new Headlang();
        $this->sprache=$lang->loadSprache();
        
        print('<meta charset="UTF-8" ><meta name="author" content="Hans Wornik"><head><meta name="viewport" content="width=device-width"/><link rel="stylesheet" type="text/css" href="/webtech/normal/style.css"><script  type="text/javascript" src="');
                        print('./scripts/jscript.js" ></script><script  type="text/javascript" src="');
                        print('./scripts/sha256.js" ></script><script  type="text/javascript" src="');
                        print('./scripts/Aes.js" ></script>');
                        print('<title>dates&friends</title>');
                        print('<link rel="stylesheet" href="//localhost/webtech/dijit/themes/tundra/tundra.css" media="screen">');
                        print('<script src="//localhost/webtech/dojo/dojo.js" data-dojo-config="async: true"></script>');

        }
        
        public function makerefresh(){
            print('<meta http-equiv="refresh" content="60; URL=index.php?neuigkeiten">');
        }

        public function anfang($jscriptfunc) {
            print('</head>
             <body onload="'.$jscriptfunc.'" class="tundra"> 
             <header><banner></banner>');

        }

        
        
        public function title() {
        print('<h1 id="titel">Dates & Friends</h1>'); 
    }
    
    public function login() {
    $data='<loginform><div data-dojo-type="dijit/DropDownMenu" id="navMenu">
            <div data-dojo-type="dijit/PopupMenuItem"  ><span>'.$_SESSION['language'].'</span><languagedrop data-dojo-type="dijit/DropDownMenu"  id="submenu">
            <div data-dojo-type="dijit/MenuItem" onClick="changeLanguage(\'de\')">de</div>
            <div data-dojo-type="dijit/MenuItem" onclick="changeLanguage(\'en\')">en</div></div></div></languagedrop>'
            .'<script>
            // Require dependencies
            require([
                "dijit/Menu",
                "dijit/MenuItem",
                "dijit/PopupMenuItem",
                "dojo/parser",
                "dojo/domReady!"
            ], function(Menu, MenuItem, PopupMenuItem, parser){
                parser.parse();
            });
        </script>';
        //$data=$data.'<loginform>'.$this->sprache[0].' <input  id="logon" > <input  id="cookie" ><checkit id="checkit">'.$this->sprache[1].'</checkit>';
         $data=$data.'<loginform>';
          $data=$data.'<div data-dojo-type="dijit/form/DropDownButton">
            <span>Login</span><!-- Text for the button -->
            <!-- The dialog portion -->
            <div data-dojo-type="dijit/TooltipDialog" id="ttDialog">
                <strong><label for="email" style="display:inline-block;width:100px;">Email:</label></strong>
                <div data-dojo-type="dijit/form/TextBox" id="logon" id="email"></div>
                <br />
                <strong><label for="pass" style="display:inline-block;width:100px;">Password:</label></strong>
                <div data-dojo-type="dijit/form/TextBox" type="password" id="passwort"></div>
                <br />
                 <checkit id="checkit" style="padding-left:100px"  > '.$this->sprache[1].'  </checkit>  <input  id="cookie" type="checkbox" style="padding-left:100px" ><br />
                <button data-dojo-type="dijit/form/Button" onclick="person.sendAll()" style="padding-left:100px" >Submit</button>
            </div>
        </div>';
         //$data=$data.'<button  class="button1" id="buttonlogon"   >  '.$this->sprache[2].'  </button>';
         $data=$data.'<button class="button1" id="buttonregister" > '.$this->sprache[3].' </button>';
         $data=$data.'<button class="button1" id="buttonreregister" > '.$this->sprache[11].' </button>';        
         $data=$data.'</loginform>';
                       
        echo $data;

    }
    
    public function loginphp($jvascrpt) {
         if(!$jvascrpt)
         {
                print('<form action="?Logon" method="post">');
         }
        print('<loginform>'
                .$this->sprache[4].' <input type="text"  id="logon" name="meins">');
        if($jvascrpt)
        {
               print('<button onclick="person.sendID()">'.$this->sprache[2].'</button><br>');
        }
        else
        {
               print('<button onclick="submit">'.$this->sprache[5].'</button><br>');
        }
        print('<a href="?Register">'.$this->sprache[6].'</a><br>');
        if($jvascrpt)
        {
            print('<checkit>'.$this->sprache[10].'</checkit><input type="checkbox" name="secure" value="secure">');
        }
        print('<checkit>'.$this->sprache[7].'</checkit><input type="checkbox" name="cookie" value="cookie">');
        print('</loginform>');
        if(!$jvascrpt)
        {
            print('</form>');
        }

    }
    
    public function bild() {
        print('<userbild>');
        print('<img class="profilbild" src="/webtech/bilder/'.$_SESSION['userid'].'.gif" alt="Person" ></userbild>'
        .'<loginform><button class="button1" data-dojo-type="dijit/form/Button" onclick="window.location.href=\'?Abmelden\'" name="Abmelden">'.$this->sprache[8]
        .'<button class="button1" data-dojo-type="dijit/form/Button"  onclick="window.location.href=\'?Einstellungen\'" name="Einstellungen">'.$this->sprache[9].'<loginform>');
    }
    
    public function ende() {
        print('</header>');
    }
    
    private function checkStorage() {
        
        if(isset($_GET['storage']))
        {
            if(strcmp($_SESSION['storage'], "yes"))
            {
                $_SESSION['storage']=true;
            }
            else 
            {
                $_SESSION['storage']=false;
            }
        }
        if(!isset($_SESSION['storage']))
        {
            echo "<script type=\"text/javascript\">checkStorage();</script>";
        }
   
    }
}
