<?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Diese Klasse managt die abfrage der Freunde
 */
class Start extends Model{
    
    /**
     * Abfrage der Freunde und setzt die Zeitzone
     * @param int $userid
     * @return Array der Namen der Freunde 
     */
    public function getFreunde($userid) {
        
        $dbresult=  $this->data->getFreunde($userid);
        date_default_timezone_set($this->data->getZone($userid));
        if(!is_null($dbresult))
        {
            for($i=0;$i<count($dbresult);$i++)
            {
                $row=  $this->data->getNamebyId($dbresult[$i][0]);
                $arr[]=$row[0];
            }
            return $arr;
        }
        else 
        {
            return null;
        }
    }
}
