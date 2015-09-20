<?php
class Head {
    
    public function show() {
        
        print('<meta charset="UTF-8" ><meta name="author" content="Hans Wornik"><head><meta name="viewport" content="width=device-width"/><link rel="stylesheet" type="text/css" href="/webtech/normal/style.css"><script  type="text/javascript" src="');
                        print('./scripts/jscript.js" ></script><script  type="text/javascript" src="');
                        print('./scripts/sha256.js" ></script><script  type="text/javascript" src="');
                        print('./scripts/Aes.js" ></script>');
                        print('<title>dates&friends</title>');
                        print('<script src="//ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"
                            data-dojo-config="async: true"></script>');

        }
        
        public function makerefresh(){
            print('<meta http-equiv="refresh" content="60; URL=index.php?neuigkeiten">');
        }

        public function anfang($jscriptfunc) {
            print('</head>
             <body onload="'.$jscriptfunc.'"> 
             <header><banner></banner>');

        }

        
        
        public function title() {
        print('<h1 id="titel">Dates & Friends</h1>');     
    }
    
    public function login() {
        
        $data='<loginform>Login: <input type="text"  id="logon" name="meins">';
        $data=$data.'<button onclick="person.sendID()">login</button><br>';
        $data=$data.'<a href="?Register">Registrieren</a><br>';
        $data=$data.'<checkit>PC speichern</checkit><input type="checkbox" id="cookie" >';
        $data=$data.'</loginform>';
        echo $data;

    }
    
    public function loginphp($jvascrpt) {
         if(!$jvascrpt)
         {
                print('<form action="?Logon" method="post">');
         }
        print('<loginform>'
                .'Login: <input type="text"  id="logon" name="meins">');
        if($jvascrpt)
        {
               print('<button onclick="person.sendID()">login</button><br>');
        }
        else
        {
               print('<button onclick="submit">login</button><br>');
        }
        print('<a href="?Register">Registrieren</a><br>');
        if($jvascrpt)
        {
            print('<checkit>Sichere Übertragung</checkit><input type="checkbox" name="secure" value="secure">');
        }
        print('<checkit>PC speichern</checkit><input type="checkbox" name="cookie" value="cookie">');
        print('</loginform>');
        if(!$jvascrpt)
        {
            print('</form>');
        }

    }
    
    public function bild() {
        print('<userbild>');
        print('<img class="profilbild" src="/webtech/bilder/'.$_SESSION['userid'].'.gif" alt="Person" >'
        .'    <form method="get" action="">
                    <input class="button" type="submit" value="Abmelden" name="Abmelden">
                </form><br>'
        .'<form method="get" action="">
                    <input class="button" type="submit" value="Einstellungen" name="Einstellungen">
                </form><br>');
        print('</userbild>');
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
                echo 'Storage geht<br>';
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
