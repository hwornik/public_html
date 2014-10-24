<?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 * Diese Klasse managt die Termine
 */
class Termin extends Model {
    
    /**
     * Fragt die belegten Zeiten für alle Teilnehmer an bestimmten Tag ab
     * @param type $userid      int userid
     * @param type $termindate  Array mit Termindaten
     * @param type $freunde     String mit index der Teilnehmer getrennt mit ;
     * @return null|Array mit belegten Zeiten aller Teilnehmer
     */
    public function getTeilnehmerZeit($userid,$termindate,$freunde) {

        $teilnehm= explode(';',$termindate['teilnehmer']);
        if(strcmp($termindate['offen'],'true')==0)
        {
            $off=true;
        }
        else
        {
            $off=false;
        }
        $this->validt= new Validator_Number();
        if($this->validt->check($termindate['monat']) && $this->validt->check($termindate['tag']) && $this->validt->check($termindate['jahr']))
        {
            $von=mktime(0,0,0,$termindate['monat']+1,$termindate['tag'],$termindate['jahr']);
            $bis=mktime(24,0,0,$termindate['monat']+1,$termindate['tag'],$termindate['jahr']);
            $dates=  $this->data->getDates($userid,$von,$bis,$off);
            $rowe=null;
            if(!is_null($dates))
            {
                
                foreach($dates as $row)
                {
                    $rowex =  $this->data->getDateTime($row['dateid']);
                    $rowe[] = $rowex[0];
                }
                $dates=$rowe;
                $date['werte']=$this->sortTimes($dates);
                $date['werte']=$this->mergeTime($date['werte']);
            }
            else 
            {
                $date['werte']=null;
            }
            $date['freundname']='ich';
            $date['userid']=$userid;
            $daten[]=$date;
  
            for ($i = 0; $i < (count($teilnehm)-1); $i++)
            {
                $rowe=null;
                $dates=  $this->data->getDates($freunde[$teilnehm[$i]]['userid'],$von,$bis,$off);
                if(!is_null($dates))
                {
                    foreach($dates as $row)
                    {
                        $rowex=  $this->data->getDateTime($row['dateid']);
                        $rowe[] = $rowex[0];
                    }
                    $dates=$rowe;
                    $date['werte']=$this->sortTimes($dates);
                    $date['werte']=$this->mergeTime($date['werte']);
                }
                else 
                {
                    $date['werte']=null;
                }
                $date['freundname']=$freunde[$teilnehm[$i]]['vname'].' '.$freunde[$teilnehm[$i]]['nname'];
                $date['userid']=$freunde[$teilnehm[$i]]['userid'];
                $daten[]=$date;
            }

            return $this->datenToString($daten);


        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Sortieren des Arrays der Teilnehmer mit Zeiten
     * @param type $dates
     * @return $dates sortiert
     */
    public function sortTimes($dates) {

        if(!is_null($dates))
        {
            foreach ($dates as $key => $row) {
                $start[$key]    = $row['von'];
                $ende[$key] = $row['bis'];
            }
            array_multisort($start, SORT_ASC, $dates);
            return $dates;
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Zusammenführen von überschneidenden Terminzeiten
     * @param type $data
     * @return null|$data mit den Zeiten
     */
    public function mergeTime($data) {
        
        if(!is_null($data))
        {
            $datanew=null;
            $datanew[]=$data[0];
            $j=0;
            $i=1;
            while($i<count($data))
            {
                if($datanew[$j]['bis']<$data[$i]['von'])
                {
                    $datanew[]=$data[$i];
                    $j++;
                }
                else if($datanew[$j]['bis']<$data[$i]['bis'])
                {
                    $datanew[$j]['bis']=$data[$i]['bis'];
                }
                $i++;
            }
            return $datanew;
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Übersetzung der time() in Dateobjekt
     * @param type $daten
     * @return type $daten mit date()
     */
    private function datenToString($daten)  {
        $i=0;
        foreach  ($daten as $row){
            $data='';
            if(is_null($row['werte']))
            {
                $data='keine Termine vorhanden';
            }
            else 
            {
                foreach ($row['werte'] as $rowd) {
                    $data=$data. ' von: '.date('G:i',$rowd['von']).' bis: '.date('G:i',$rowd['bis']).' ';
                }
            }
            $erg[]= array( freundname => $row['freundname'], userid => $row['userid'], werte => $data);
        }
        return $erg;
    }
    
    /**
     * Termin erstellen
     * @param type $dat             Tag
     * @param type $freunde         Teilnehmer Array
     * @param type $userid          int meine Id
     * @param type $von             Uhrzeit von in Militärzeit
     * @param type $bis             Uhrzeit bis in Militärzeit
     * @param type $text            Ort
     * @param type $bem             Anmerkung
     * @return boolean
     */
    public function bucheTermin($dat,$freunde,$userid,$von,$bis,$text,$bem) {

        $this->validt= new Validator_Number();
        if($this->validt->check($von) && $this->validt->check($bis))
        {
            $this->validt= new Validator_String();
            if($this->validt->check($text) && $this->validt->check($bem))
            {
                $datevon=$dat+(floor($von/100)*60*60)+((von%100)*60)+1;
                $datebis=$dat-1+(floor($bis/100)*60*60)+(($bis%100)*60)+1;
                $dateid=$this->data->storeDate($datevon,$datebis,$text,$bem);
                foreach($freunde as $row)
                {
                    echo 'üüü'.$row['userid'].'#g';
                    $this->data->addUsertoDate($dateid,$row['userid']);
                }
                return true;
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
     * Offene Termine abfragen
     * @param type $userid  int
     * @return dbresult offene Termine
     */
    public function getoffeneTermine($userid)  {
        
        $dbresult= $this->data->getoffeneDates($userid);
        if(!is_null($dbresult))
        {
            $datedata=$this->data->getDatefromteilnehmerData($dbresult);
            $userresult=null;
            foreach($dbresult as $row)
            {
                $userresult[]= $this->data->getallTeilnehmer($row['dateid']);
            }
            foreach($userresult as $row)
            {
                $user=null;
                foreach($row as $rowd)
                {
                    if($rowd['userid']!=$userid)
                    {
                        $userzld=$this->data->getNamebyId($rowd['userid']);
                        $userzl=$userzld[0];
                        $userzl['nimtteil']=$rowd['nimtteil'];
                        $userzl['grund']=$rowd['grund'];
                        $user[]=$userzl;
                    }
                }
                $allusers[]=$user;
            }
            $i=0;
            while(count($dbresult)>$i)
            {
                $offeneTermine[$i]= array( 'termin' => $datedata[$i], 'user' => $allusers[$i]);
                $i++;
            }
            return $offeneTermine;
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * Termin bestätigen
     * @param type $userid      int Id
     * @param type $dbresult    Terminarray
     * @param type $nummer      ausgewählte Termine codiert mit ; Trenner
     * @param type $text        Bemerkungsarray
     * @return boolean          ob ok
     */
    public function setTerminOk($userid,$dbresult,$nummer,$text,$grund) {
        $this->validt= new Validator_String();
        if($this->validt->check($nummer))
        {
            $nummern= explode(';',$nummer);
            $i=0;
            for ($i = 0; $i < (count($nummern)-1); $i++)
            {
                $this->data->setTerminOkorNot($userid,$dbresult[$i]['termin']['dateid'],' ',$grund);
            }
            return true;
        }
        return false;
    }
    
    /**
     * Bestätigte Termine Abfragen
     * @param int $userid
     * @param time() $von
     * @param time() $bis
     * @return dbresult als Termin + Teilnehmer Array
     */
    public function getbestTermine($userid,$von,$bis)  {
        if($bis==0)
        {
            $dbresult= $this->data->getbestDates($userid);
        }
        else
        {
            $dbresult=$this->data->getDates($userid,$von,$bis,false);
        }
        if(!is_null($dbresult))
        {
            $datedata=$this->data->getDatefromteilnehmerData($dbresult);
            $userresult=null;
            foreach($dbresult as $row)
            {
                $userresult[]= $this->data->getallTeilnehmer($row['dateid']);
            }
            foreach($userresult as $row)
            {
                $user=null;
                foreach($row as $rowd)
                {
                    if($rowd['userid']!=$userid)
                    {
                        $userzl=null;
                        $userzld=$this->data->getNamebyId($rowd['userid']);
                        $userzl=$userzld[0];
                        $userzl['nimtteil']=$rowd['nimtteil'];
                        $userzl['grund']=$rowd['grund'];
                        $user[]=$userzl;
                    }
                }
                $allusers[]=$user;
            }
            $i=0;
            while(count($dbresult)>$i)
            {
                $offeneTermine[$i]= array( 'termin' => $datedata[$i], 'user' => $allusers[$i]);
                $i++;
            }
            return $offeneTermine;
        }
        else 
        {
            return null;
        }
    }
}
