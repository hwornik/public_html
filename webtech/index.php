<?php
session_start();
$_SESSION['pfad']=dirname(__FILE__);
if(!isset($_SESSION['language']))
{
    $_SESSION['language']="de";
}
require_once $_SESSION['pfad'].'/controler/Controler_Start.php';
$cntrl=new Controler_Start();
$cntrl->start();
?>
