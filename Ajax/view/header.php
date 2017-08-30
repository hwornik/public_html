<?php 
class Header {
    
    public function show() {
        print(' <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="Pragma" content="no-cache">
	<meta name="author" content="Hans Wornik">
        <link rel="stylesheet" type="text/css"  href="scripts/themes/base/jquery-ui.css">
        <script  type="text/javascript" src="scripts/jquery-1.9.1.js" ></script>
         <script type="text/javascript" src="scripts/ui/jquery-ui.js"></script>
         <script>var system="');
        print($_SESSION['system']);
        print('";</script> 
         <script type="text/javascript" src="');
        if(strcmp($_SESSION['system'],"Touch Screen User")==0)
        {
            echo 'scripts/scripttouch.js';
        }
        else
        {
            echo 'scripts/script.js';
        }
    print('" ></script>
    <link rel="stylesheet" type="text/css" href="');
    if (strcmp($_SESSION['system'],'Touch Screen User')==0)
    {
        echo 'view/styletouch.css';
    }
    else
    {
        echo 'view/style.css';
    }
    print('" >
            <link type="image/x-icon" href="/Bilder/logo.png" rel="icon">

            <title>Wornik\'s Home</title>
            
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <script>
              (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-1109034345535770",
                enable_page_level_ads: true
              });
            </script>

        </head> 

            <body>
                <p class="leftbar"></p>
                <a href="/"><img class="logo"  src="/Bilder/logo.png"></a>
                <p id="middlebar"></p>
                <p class="rightbar"></p>
                <p class="pseudo"></p>     ');
    print('<a href="/"><h1>Willkommen '.$_SESSION['system'].'</h1></a>');
                }
}
