<?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Dieser Klasse steuert alle Aktionen die für Nachrichten notwendig sind
 */
class Nachricht extends Model {
  
    /**
     * Nachricht posten
     * @param type $userid      int meine Id
     * @param type $pinnwand    int Zieluser
     * @param type $dbfreund    Array von Freund-Ids
     * @param type $text        text
     * @return boolean          ob erfolgreich
     */
    public function postNachricht($userid,$pinnwand,$dbfreund,$text) {
        
        $namedb=  $this->data->getNamebyId($userid);
        $this->validt= new Validator_String();
        if($this->validt->check($text))
        {
            $this->validt= new Validator_Number();
            if($this->validt->check($pinnwand))
            {
                $name=$namedb[0]['vname'].' '.$namedb[0]['nname'];
                if($pinnwand==0)
                {
                    $pinn=$userid;
                }
                else 
                {
                    $pinn=$dbfreund[$pinnwand-1]['userid'];
                }
                $time=time();
                return $this->data->postMessage($pinn,$name,$text,$time);
            }
            else 
            {
                return false;
            }
        }
        else 
        {
            return false;
        }
    }
    
    /**
     * Alle Nachrichten abfragen
     * @param type $userid int meine Id
     * @param type $freunde Array von Freunden Id
     * @return type Array der Nachrichten
     */
    public function getAllNachrichten($userid,$freunde) {
        
        $dbresult=$this->data->getAllMessages($userid);
        for($i=0;$i<count($freunde);$i++)
        {
            $dbresult2=$this->data->getAllMessages($freunde[$i]['userid']);
            if(!is_null($dbresult) && !is_null($dbresult2))
            {
                $dbresult=$this->mergeMessages($dbresult,$dbresult2);
            }
        }
        return $dbresult;
    }
    
    /**
     * Zusammenführen und Sortieren der Messages
     * @param type $data1   Message Array 1
     * @param type $data2   Message Array 2
     * @return type         Message Array 1 + Array 2 sortiert
     */
    public function mergeMessages($data1,$data2) {
        $data=array_merge($data1,$data2);
        foreach ($data as $key => $row) {
            $volume[$key]  = $row['datum'];
        }
        array_multisort($volume, SORT_DESC, $data);
        return $data;
    }
 
}
