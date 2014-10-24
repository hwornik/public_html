<?php
require_once $_SESSION['pfad'].'/model/Validator.php';
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Diese Klasse steuert alle Aktionen einer Freundschaft
 */
class Friend extends Model {
    
    private $freundbest;
    
    /**
     * Sucht nach LIKE $word ohne $userid in der DB nach Usern
     * @param string $word  Suchstring
     * @param type $userid  int
     * @return null|dbresult Array of Friends
     */
    public function sucheFreunde($word, $userid) {
        
        $this->valid= new Validator_String();
        if($this->valid->check($word))
        {
            if(strcmp($word,'*')==0)
            {
                $word='_';
            }
            $dbfriends=$this->data->getNewFriends($word,$userid);
            $dbanfr=  $this->data->getFreundAnfrage($userid);
            $dbgesuche= $this->data->getFreundGesuche($userid);
            $i=0;
            $friends=$this->data->getFreunde($userid);
            while(!is_null($dbfriends) && $i<count($dbfriends))
            {
                $j=0;
                while($j<count($friends) || $j<count($dbgesuche) || $j<count($dbanfr))
                {
                    if(!is_null($friends) && $j<count($friends))
                    {
                        if($dbfriends[$i]['userid']==$friends[$j][0])
                        {
                            unset($dbfriends[$i]);
                            $i++;
                        }
                    }
                    if(!is_null($dbgesuche) && $j<count($dbgesuche) && $i<count($dbfriends))
                    {
                        if($dbfriends[$i]['userid']==$dbgesuche[$j][0])
                        {
                            unset($dbfriends[$i]);
                            $i++;
                        }
                    }
                    if(!is_null($dbanfr) && $j<count($dbanfr) && $i<count($dbfriends))
                    {
                        if($dbfriends[$i]['userid']==$dbanfr[$j][0])
                        {
                            unset($dbfriends[$i]);
                            $i++;
                        }
                    }
                    $j++;
                }
                $i++;
            }
            foreach($dbfriends as $row) {
                $dbfriends2[] = $row;
            }
            return $dbfriends2;
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Freundschaftsanfrage speichern
     * @param type $userid      int meine Id
     * @param type $dbresult    Array of Friends Id
     * @param type $friends     Übersetzung zu FriendsId
     * @param string $message   Text
     * @return int              Anzahl der erfolgreichen Speicherung-1
     */
    public function storeFriendsAnfrage($userid,$dbresult,$friends,$message)  {

        $freunde= explode(';',$friends);                       
        $this->validt = new Validator_String();
        if(is_null($message))
        {
            $message='';
        }
        if($this->validt->check($message) || strlen($message)==0)
        {
            $this->validt = new Validator_Number();
            for ($i = 0; $i <= (count($freunde)-1); $i++)
            {
                if($this->validt->check($freunde[$i]))
                {
                    if($this->data->storeFreundAnfrage($userid,$dbresult[$freunde[$i]]['userid'],$message))
                    {
                        return $i;
                    }
                }
                else 
                {
                    return $i-1;
                }
                
            }
            return $i;
        }
        else 
        {
            return -1;
        }

    }
    
    /**
     * Abrufen der Freundschaftsansuchen
     * @param type $userid
     * @return null|Array von NameArray und message der Anfrage
     */
    public function getFreundAnfr($userid) {
        
        $this->freundbest=  $this->data->getFreundAnfrage($userid);
        if(!is_null($this->freundbest))
        {
            
            for($i=0;$i<count($this->freundbest);$i++)
            {
                $row=$this->data->getNamebyId($this->freundbest[$i][0]);
                $row[0]['message']= $this->freundbest[$i][1];
                $arr[]=$row[0];
            }
            return $arr;
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Freundbestätigung  von $this->getFreundAnfr abrufen
     * @return type dbResultArray
     */
    public function getFreundAnfrgID() {
        return $this->freundbest;
    }

    /**
     * Meine Gesuche Abfragen
     * @param type $userid int my Id
     * @return null|array of Freundnamen
     */
    public function getFreundGes($userid) {
        
        $dbresult=  $this->data->getFreundGesuche($userid);
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
    
    /**
     * Freundschaftsanfragen bestätigen
     * @param type $userid  int myId
     * @param type $dbres   Array von Freunden
     * @param type $friends Übersetzung der Auswahl
     * @return int anzahl der bestätigten anfragen-1
     */
    public function bestaetigeFreunde($userid,$dbres,$friends) {
            echo $friends;
            $freunde= explode(';',$friends);
            print_r($dbres);
            $this->validt = new Validator_Number();
            for ($i = 0; $i < (count($freunde)-1); $i++)
            {
                if($this->validt->check($freunde[$i]))
                {
                    echo 'p'.$dbres[$freunde[$i]][0].'#'.$userid.'<br>';
                    if($this->data->storeFreundschaft($dbres[$freunde[$i]][0],$userid,''))
                    {
                        return $i;
                    }
                }
                else 
                {
                    return $i-1;
                }
                
            }
            return $i;
        }
       
}
