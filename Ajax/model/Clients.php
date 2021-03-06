<?php
/**
 * Description of Clients
 *
 * @author hans
 */
class Clients {
    //put your code here
    private function getBrowser() 
    { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        //print($u_agent);
        //First get the platform?
        if (preg_match('/Android/i', $u_agent)) {
            $platform = 'android';
        }
        elseif (preg_match('/iPhone/i', $u_agent)) {
            $platform = 'iPhone';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        elseif (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $ub,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
    
    public function getSystem() {
        
                // now try it
        $ua=$this->getBrowser();
        if ($ua['platform']  == 'windows')
        {
                return array(
                                'system' => "Windows User",
                                'name'      => $ua['name']
                             );
        }
        elseif ($ua['platform'] =='mac')
        {
                return array(
                    'system' => "Mac User",
                    'name'      => $ua['name']
                 );
        }
        elseif ($ua['platform'] =='android' || $platform=='iPhone')
        {
                return array(
                    'system' => "Touch Screen User",
                    'name'      => $ua['name']
                 );
        }
        else
        {
                return array(
                    'system' => "Freund",
                    'name'      => $ua['name']
                 );
        }
    }
}

?>
