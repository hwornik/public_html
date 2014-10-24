<?php
session_start();
$_SESSION['pfad']=dirname(__FILE__);
if(isset($_GET['switch']))
{
    $_SESSION['system']='Switcher';
    if (strcmp($_GET['switch'],'Touch')==0)
    {
        $_SESSION['system']='Touch Screen User';
    }
    else
    {
        $_SESSION['system']='Switcher';
    }
}
echo'<script type="text/javascript">
                 self.location.href="/Ajax/"
            </script>';
require_once $_SESSION['pfad'].'/Controller/Controller.php';
$ctrl = new Controller();
$ctrl->init();

include $_SESSION['pfad'].'/View/header.php'; // Include the Header
include $_SESSION['pfad'].'/View/navbar.php'; // Include the Navigation Area

print('<div id="TextFeld">');
    
print($_SESSION['browser']) ;      
print($ctrl->getText());


print('</div>');

include $_SESSION['pfad'].'/View/sidebar.php'; // Include the Sidebar
include $_SESSION['pfad'].'/View/footer.php';
?>