<html>
<head>

    <meta charset="UTF-8" >
	<meta name="author" content="Hans Wornik">
    <script  type="text/javascript" src="/Scripts/script.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php
    if (strcmp($_SESSION['system'],'Touch Screen User')==0)
    {
        echo '/View/style.css';
    }
    else
    {
        echo '/View/style.css';
    }
    ?>" >
    <link type="image/x-icon" href="/Bilder/logo.png" rel="icon">
	
    <title>Wornik's Home</title>
   
</head> 
<body onload="treeMenu_init(document.getElementById('menu'), '')">
    
    <p class="pseudo"></p>
    <p class="leftbar"></p>
    <a href="/"><img class="logo"  src="/Bilder/logo.png"></a>
    
<a id="Buttonblog" href="http://blog.wornik.eu" >tales<br> of<br> an<br> angry<br> old<br> man</a>