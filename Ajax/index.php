<?php
session_start();
$_SESSION['pfad']=dirname(__FILE__);
include_once  $_SESSION['pfad'].'/Controller/Controller.php';
$ctrl = new Controller();
$ctrl->init();
$ctrl->showHeader();
$ctrl->showNavbar();
$ctrl->showCenter();
$ctrl->showSidebar();
$ctrl->showfooter();
?>