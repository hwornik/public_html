<?php
/**
 * Description of Clients
 *
 * @author hans
 */
class Clients {
    //put your code here
    public function getBrowser() 
    { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub="";
        //print($u_agent);
        //First get the platform?
        if (preg_match('/Android/i', $u_agent)) {
            $platform = 'Android';
        }
        elseif (preg_match('/iPhone/i', $u_agent)) {
            $platform = 'iOS';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        }
        elseif (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'OSX';
        }
        return $platform;
    }

}

?>
