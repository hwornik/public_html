<?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 */
require_once $_SESSION['pfad'].'/model/Person.php';
/**
 * Data Kommunikation mit der Datenbank
 */
class Data {
    
        private $host='localhost';
        private $database='u32154db10';
        private $user='u32154db10';
        private $passwt='hfz4aahh';
        private $options=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        
        /**
         * 
         * @return \PDO|nullMit der Datenbank verbinden
         * return Datenbankverbindung
         */
        private function connect() {
            try {
            return new PDO('mysql:host='.$this->host.';dbname='
                    .$this->database, $this->user, $this->passwt,  $this->options);
            }
            catch (Exception $e) {
                return null;
            }
        }

        /**
         * Abspeichern neuer Personendaten
         * @param Person $person
         * @return boolean ob gespeichert
         */
        public function storePerson(Person $person) {
          
            $conn = $this->connect();
            try {
                
            $stmt=$conn->prepare("INSERT INTO users ( nick, vname, nname, login, email, strasse, ort, land, passwd, activecode, foto, activelink) VALUES (:nick, :vname, :nname, :login, :email, :str, :ort, :land, :passwd, :activecode, :foto, :activelink)");
            $stmt->bindParam(':nick', $person->getNick());
            $stmt->bindParam(':vname',$person->getVorname());
            $stmt->bindParam(':nname', $person->getNachname());
            $stmt->bindParam(':login',$person->getLogon());
            $stmt->bindParam(':email',$person->getEmail());
            $stmt->bindParam(':str',$person->getStrasse());
            $stmt->bindParam(':ort',$person->getOrt());
            $stmt->bindParam(':land',$person->getLand());
            $stmt->bindParam(':passwd', $person->getPasswt());
            $stmt->bindParam(':activecode',$person->getCode());
            $stmt->bindParam(':foto',$person->getFoto());
            $stmt->bindParam(':activelink',$person->getLink());
            $stmt->execute();
            return true;      
            
            } catch (Exception $e) {
    
                return false;
            }
        }
        
        /**
         * Ändern der Personendaten
         * @param Person $person
         * @return boolean ob geändert
         */
        public function updatePerson(Person $person) {
          
            $conn = $this->connect();
            try {
                
            $stmt=$conn->prepare("UPDATE users  SET nick = :nick, vname = :vname, nname = :nname, email = :email, strasse = :str, ort = :ort, land = :land WHERE userid = :userid");
            $stmt->bindParam(':nick', $person->getNick());
            $stmt->bindParam(':vname',$person->getVorname());
            $stmt->bindParam(':nname', $person->getNachname());
            $stmt->bindParam(':email',$person->getEmail());
            $stmt->bindParam(':str',$person->getStrasse());
            $stmt->bindParam(':ort',$person->getOrt());
            $stmt->bindParam(':land',$person->getLand());
            $stmt->bindParam(':userid',$person->getUserId());
            $stmt->execute();
            return true;      
            
            } catch (Exception $e) {
   
                return false;
            }
        }
        
        /**
         * Passwort ändern, mit überprüfung ob altes Passwort ok ist
         * @param type $userid  bigint userid
         * @param type $passwt  altes Passwort
         * @param type $newpasswt   neues Passwort
         * @return boolean ob geändert
         */
        public function changePasswt($userid,$passwt,$newpasswt) {
           
            $conn = $this->connect();
            try {
                
            $stmt=$conn->prepare("UPDATE users  SET passwd = :newp WHERE (userid = :userid and passwd = :passwd)");
            $stmt->bindParam(':newp', $newpasswt);
            $stmt->bindParam(':userid',$userid);
            $stmt->bindParam(':passwd', $passwt);
            $stmt->execute();
            return true;      
            
            } catch (Exception $e) {

                return false;
            }
        }
        
        /**
         * sucht den Aktivierungscode über den aktivierungslink
         * @param type $link    link von Email
         * @return String aktivecode oder null
         */
        public function getActiveCode($link) {
              
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM users WHERE activelink = :code");
                $stmt->bindParam(':code', $link);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult[0]['activecode'];
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {
   
                return null;

            }
        }
        
        /**
         * Aktivieren einer Person über code
         * @param type $code aktivierungscode
         * @param type $passwt  neues Passwort
         * @return boolean ob aktivierung erfolgreich
         */
        public function setPersonActvebyCode($code, $passwt) {
              
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM users WHERE activecode = :code");
                $stmt->bindParam(':code', $code);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);

                if(count($dbresult)>0)
                {
                    $conn = $this->connect();
                    $stmt = $conn->prepare("UPDATE users SET activelink = :neue, activecode = :leer, passwd = :passwt WHERE userid = :id ");
                    $stmt->bindParam(':id', $dbresult[0]['userid']);
                    $leer='';
                    $stmt->bindParam(':leer', $leer);
                    $stmt->bindParam(':neue', $leer);
                    $stmt->bindParam(':passwt', $passwt);
                    $stmt->execute();
                    return true;
                }
                else 
                {
                    return false;
                }
                
            } catch (Exception $e) {
    
                return false;

            }
        }
        
        /**
         * Sucht Passwort zu login
         * @param type $login
         * @return \Person|null passwort und userid wenn erfolgreich sonst null
         */
        public function getPasswbyLogon($login) {
              
           
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM users WHERE login = :login");
                $stmt->bindParam(':login', $login);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    $pers = new Person();
                    $pers->setPasswt($dbresult[0]['passwd']);
                    $pers->setUserID($dbresult[0]['userid']);
                    return $pers;
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {
 
                return null;

            }
        } 
        
        /**
         * Sucht Passwort zu userid als int
         * @param type $login int
         * @return null oder passwort bei Erfolg
         */
        public function getPasswbyId($login) {
              
           
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT passwd FROM users WHERE userid = :login");
                $stmt->bindParam(':login', $login);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
  
                    return $dbresult[0]['passwd'];
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {

                return null;

            }
        }

        /**
         * Abspeichern eines Cookie zum Autologin
         * @param type $user  logon
         * @param type $code  CookieString
         * @param type $ende time() Verfalldatum
         * @return boolean ob erfolgreich
         */
        public function setCookie($user, $code, $ende) {
            
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM nownpc WHERE ende < :ende");
                $stmt->bindParam(':ende', time());
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                     $conn = $this->connect();
                     $stmt=$conn->prepare("UPDATE nownpc SET cookie = :code, logon = :logon, ende = :ende WHERE nownpcid = :nownpcid");
                     $stmt->bindParam(':code', $code);
                     $stmt->bindParam(':logon', $user);
                     $stmt->bindParam(':ende', $ende);
                     $stmt->bindParam(':nownpcid', $dbresult[0]['nownpcid']);
                     $stmt->execute();
                     return true;
                }
                else
                {
                    $conn = $this->connect();
                    $stmt=$conn->prepare("INSERT INTO nownpc ( logon , cookie, ende) VALUES (:login, :code, :ende) ");
                    $stmt->bindParam(':code', $code);
                    $stmt->bindParam(':login', $user);
                    $stmt->bindParam(':ende', $ende);
                    $stmt->execute();
                    return true;
                }
                
            } catch (Exception $e) {
  
                return false;

            }
        }
        
        /**
         * Abfragen des Logon nach Cookie
         * @param type $cookie Wert des Cookie
         * @return string|null  logon wenn erfolgreich sonst null
         */
        public function getUserByCookie($cookie) {
            
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM nownpc WHERE cookie = :code");
                $stmt->bindParam(':code', $cookie);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult[0]['logon'];
                }
                else 
                {
                    return '';
                }
                
            } catch (Exception $e) {
 
                return null;

            }
            
        }
        
        /**
         * Sucht eigene FReundschaftsanfragen
         * @param type $user int userid
         * @return string|null Dbresult Array oder null
         */
        public function getGesuche($user)  {
            
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM istbefreundetmit WHERE userida = :user");
                $stmt->bindParam(':user', $user);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return '';
                }
                
            } catch (Exception $e) {
   
                return null;

            }
            
        }
        
        /**
         * Sucht Freundschaftsanfragen
         * @param type $user int userid
         * @return string|null DBResult Freundschaftsanfragen oder null
         */
        public function getAnfragen($user)  {
            
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM istbefreundetmit WHERE useridb = :user");
                $stmt->bindParam(':user', $user);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return '';
                }
                
            } catch (Exception $e) {
 
                return null;

            }
            
        }
        
        /**
         * Testet ob email bereits in Datenbank ist
         * @param type $email Adresse
         * @return boolean ob vorhanden
         */
        public function checkEmail($email) {
            
                      
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return false;
                }
                else 
                {
                    return true;
                }
                
            } catch (Exception $e) {

                return false;

            }
        }

        /**
         * Testet ob login hash bereits in der Datenbank ist
         * @param type $login hash
         * @return boolean ob vorhanden
         */
        public function checkLogon($login) {
            
                      
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT * FROM users WHERE login = :login");
                $stmt->bindParam(':login', $login);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return false;
                }
                else 
                {
                    return true;
                }
                
            } catch (Exception $e) {
 
                return false;

            }
        }
        
        /**
         * Freundsuche ohne eigenen Eintrag
         * @param string $link Suchwort
         * @param type $userid eigene int userid
         * @return null|$dbresult  von Name und nicks der entsprechenden user
         */
        public function getNewFriends($link,$userid) {
              
            $conn = $this->connect();
            
            try {
                $link='%'.$link.'%';
                $stmt=$conn->prepare("SELECT userid, nick, vname, nname FROM users WHERE (((nick LIKE :term) or (vname LIKE :term1) or (nname LIKE :term2 )) and (userid <> :userid) )ORDER BY nname ");
                $stmt->bindParam(':term', $link);
                $stmt->bindParam(':term1', $link);
                $stmt->bindParam(':term2', $link);
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {
  
                return null;

            }
        }
        
        /**
         * Speichere Freundschaftsbeziehung
         * @param type $userida int userid 1
         * @param type $useridb int userid 2
         * @param type $message Bemerkung
         * @return boolean ob erfolgreich
         */
        public function storeFreundschaft($userida,$useridb,$message) {
            
            $conn = $this->connect();
            try {               
            $stmt=$conn->prepare("INSERT INTO istbefreundetmit ( userida, useridb, message) VALUES (:userida, :useridb, :message)");
            $stmt->bindParam(':userida', $userida);
            $stmt->bindParam(':useridb',$useridb);
            $stmt->bindParam(':message', $message);
            $stmt->execute();
            $this->deleteAnfrage($userida,$useridb);
            return true;      
            
            } catch (Exception $e) {
   
                return false;
            }
            
        }
        
        /**
         * Freundschaftsanfrage auf null setzen
         * @param type $userida
         * @param type $useridb
         * @return boolean ob erfolgreich
         */
        private function deleteAnfrage($userida,$useridb) {
            
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("UPDATE anfrage SET userida = :leer1, useridb = :leer2 WHERE ((userida = :userida) and (useridb = :useridb))");
                $leer=0;
                $stmt->bindParam(':leer1', $leer);
                $stmt->bindParam(':leer2', $leer);
                $stmt->bindParam(':userida', $userida);
                $stmt->bindParam(':useridb', $useridb);
                $stmt->execute();
                return true;
               
            } catch (Exception $e) {

            }
        }
        
        /**
         * eigene Freundschaftsanfragen abrufen
         * @param type $userid int meine id
         * @return null|dbresult an Anfragen
         */
        public function getFreundGesuche($userid)  {
            
            $conn = $this->connect();
            
            try {
               
                $stmt=$conn->prepare("SELECT useridb, message FROM anfrage WHERE userida = :userid ORDER BY useridb ");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_NUM);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {

                return null;

            }
        }
        
        /**
         * Freundschaftsanfragen abrufen
         * @param type $userid int eigene Id
         * @return null|dbresult an Ergebnissen
         */
        public function getFreundAnfrage($userid)  {
            
            $conn = $this->connect();
            
            try {

                $stmt=$conn->prepare("SELECT userida, message FROM anfrage WHERE useridb = :userid ORDER BY userida ");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_NUM);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {

                return null;

            }
        }
        
        /**
         * Freundschaftsanfrage speichern
         * @param type $userida meine Id
         * @param type $useridb andere Id
         * @param type $message Bemerkung
         * @return boolean ob erfolgreich
         */
        public function storeFreundAnfrage($userida,$useridb,$message) {
            
            
            if($this->notInAnfrage($userida, $useridb))
            {
                $conn = $this->connect();
                try {
                    
                $stmt=$conn->prepare("INSERT INTO anfrage ( userida, useridb, message ) VALUES ( :userida, :useridb, :message )");
                $stmt->bindParam(':userida', $userida);
                $stmt->bindParam(':useridb',$useridb);
                $stmt->bindParam(':message', $message);
                $stmt->execute();
 
                return true;      

                } catch (Exception $e) {

                    return false;
                }
            }
            else 
            {
                return false;
            }
            
        }
        
        /**
         * Eigene FReunde Abfragen
         * @param type $userid int meine id
         * @return null|dbresult alller Freunde
         */
        public function getFreunde($userid) {
            
            $conn = $this->connect();
            
            try {

                $stmt=$conn->prepare("SELECT useridb FROM istbefreundetmit WHERE userida = :userid ORDER BY useridb ");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult1=$stmt->fetchAll(PDO::FETCH_NUM);
                $conn = $this->connect();
                $stmt=$conn->prepare("SELECT userida FROM istbefreundetmit WHERE useridb = :userid ORDER BY userida ");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult2=$stmt->fetchAll(PDO::FETCH_NUM);
                if(count($dbresult1)>0)
                {
                    if(count($dbresult2)>0)
                    {
                        return array_merge($dbresult1,$dbresult2);
                    }
                    else 
                    {
                        return $dbresult1;
                    }
                }
                else
                {
                    if(count($dbresult2)>0)
                    {
                        return $dbresult2;           
                    }
                    else 
                    {
                        return null;
                    }
                }

                
            } catch (Exception $e) {

                return null;

         
            }
        }
        
        /**
         * Abfrage der Userdaten
         * @param type $userid int
         * @return null|UserdatenArray
         */
        public function getUserData($userid) {
              
            $conn = $this->connect();
            
            try {
  
                $stmt=$conn->prepare("SELECT * FROM users WHERE  userid = :userid");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult[0];
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {

                return null;

            }
        }
        
        /**
         * Nick Vorname und Nachname zu UserId abfragen
         * @param type $userid int
         * @return null|Array der Daten
         */
        public function getNamebyId($userid) {
              
            $conn = $this->connect();
            
            try {
  
                $stmt=$conn->prepare("SELECT userid, nick, vname, nname FROM users WHERE  userid = :userid ORDER BY nname ");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {
 
                return null;

            }
        }
        
        /**
         * Testet ob die Userids bereits in der AnfrageTable enthalten sind
         * @param type $userida int
         * @param type $useridb int
         * @return boolean ob userid's existieren
         */
        private function notInAnfrage($userida,$useridb) {
            
            $conn = $this->connect();
            
            try {

                $stmt=$conn->prepare("SELECT * FROM anfrage WHERE (((userida = :userida) and (useridb = :useridb)) or ((userida = :useridb1) and (useridb = :userida1))) ORDER BY userida ");
                $stmt->bindParam(':userida', $userida);
                $stmt->bindParam(':userida1', $userida);
                $stmt->bindParam(':useridb', $useridb);
                $stmt->bindParam(':useridb1', $useridb);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_NUM);
                if(count($dbresult)>0)
                {
                    return false;
                }
                else 
                {
                    return true;
                }
                
            } catch (Exception $e) {

                return true;

            }
        }
        
        /**
         * Message posten
         * @param type $pinnwand Zielperson
         * @param type $name    Ersteller
         * @param type $text    Text
         * @param type $time    Zeit der erstellung
         * @return boolean  ob erfolgreich
         */
        public function postMessage($pinnwand,$name,$text,$time) {
            
            $conn = $this->connect();

            try {

            $stmt=$conn->prepare("INSERT INTO messages ( useridfrom, useridto, message, datum) VALUES (:name, :userid, :message, :time)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':userid',$pinnwand);
            $stmt->bindParam(':message', $text);
            $stmt->bindParam(':time', $time);
            $stmt->execute();
            return true;      

            } catch (Exception $e) {

                return false;
            }
        }
        
        /**
         * Abfrage aller Messages eines user/Pinnwad
         * @param type $userid Pinnwand
         * @return null|dbresult Messages
         */
        public function getAllMessages($userid)  {
            
            $conn = $this->connect();
            
            try {
                
                $stmt=$conn->prepare("SELECT useridfrom, useridto, message, datum FROM messages WHERE useridto = :pinn ORDER BY datum ");
                $stmt->bindParam(':pinn', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {
 
                return null;

            }
        }
        
        /**
         * Zeitzone abfragen
         * @param type $userid
         * @return null|String Zeitzone
         */
        public function getZone($userid) {
            
           $conn = $this->connect();
            
            try {
  
                $stmt=$conn->prepare("SELECT timezone FROM users WHERE  userid = :userid");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult[0]['timezone'];
                }
                else 
                {
                    return null;
                }
                
            } catch (Exception $e) {
 
                return null;

            } 
        }
        
        /**
         * Termine Abfragen abhängig von der Zeit
         * @param type $userid  int
         * @param type $von     time()
         * @param type $bis     time()
         * @param type $off     boolean ob offene berücksichtigt werden sollen
         * @return null|dbresult von dateid und nimtteil
         */
        public function getDates($userid,$von,$bis,$off) {
           
            $conn = $this->connect();
            
            try {
                $result=null;
                $stmt=$conn->prepare("SELECT dateid,nimtteil FROM teilnehmer WHERE  userid = :userid");
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                for($i=0;$i<count($dbresult);$i++)
                { 
                    if(!(strpos($dbresult[$i]['nimtteil'],'b')===false) || ($off && !(strpos($dbresult[$i]['nimtteil'],'o')===false)))
                    {
                        $time=$this->getDateTime($dbresult[$i]['dateid']);
                        if(!is_null($time[0]) && $time[0]['von']>$von && $time[0]['von']<$bis)
                        {
                            $result[]=$dbresult[$i];
                        }
                    }
                }
                return $result;
                
            } catch (Exception $e) {

                return null;

            }
        }
        
        /**
         * Zeit von einem Termin abfragen
         * @param type $dateidint
         * @return null|Array von,bis
         */
        public function getDateTime($dateid) {
           
            $conn = $this->connect();
            
            try {
  
                $stmt=$conn->prepare("SELECT von,bis FROM dates WHERE  dateid = :dateid");
                $stmt->bindParam(':dateid', $dateid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }

                
            } catch (Exception $e) {
   ;
                return null;

            }
        }
        
        /**
         * Termin speichern
         * @param type $datevon time()
         * @param type $datebis time()
         * @param type $text    String Ort
         * @param string $bem   String Anmerkung
         * @param type $userid  int userid
         * @return type int dateid oder -1 bei Fehler
         */
        public function storeDate($datevon,$datebis,$text,$bem) {
            
            $conn = $this->connect();
            try {

            $stmt=$conn->prepare("INSERT INTO dates ( ort, von, bis, text) VALUES (:ort, :von, :bis, :text )");
            $cod1='#abcde';
            $cod2='xuserid';
            $stmt->bindParam(':ort', $cod1);
            $stmt->bindParam(':von',$datevon);
            $stmt->bindParam(':bis', $datebis);
            $stmt->bindParam(':text', $cod2);
            $stmt->execute();
            $conn = $this->connect();
            $stmt=$conn->prepare("SELECT dateid FROM dates WHERE  ((ort = :ort) and (text = :text))");
            $stmt->bindParam(':ort', $cod1);
            $stmt->bindParam(':text', $cod2);
            $stmt->execute();
            $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($dbresult)>0)
            {
                if((strcmp($cod1,$text)==0) )
                {
                    $bem='';
                }
                $conn = $this->connect();
                $stmt=$conn->prepare("UPDATE dates SET ort = :ort, text = :text WHERE dateid = :dateid ");
                $stmt->bindParam(':ort', $text);
                $stmt->bindParam(':text', $bem);
                $stmt->bindParam(':dateid', $dbresult[0]['dateid']);
                $stmt->execute();
                return $dbresult[0]['dateid'];
                
            }
            else 
            {
                return -1;
            }

            } catch (Exception $e) {
                return -1;
            }
        }
        
        /**
         * Hinzufügen von User zu Termin
         * @param type $dateid  int
         * @param type $userid  int
         * @return boolean ob erfolgreich
         */
        public function addUsertoDate($dateid,$userid) {
            
              
            $conn = $this->connect();

            try {

            $stmt=$conn->prepare("INSERT INTO teilnehmer ( dateid, userid, nimtteil, grund ) VALUES (:dateid, :userid, :nimtteil, :grund )");
            $cod1='o';
            $cod2='';
            $stmt->bindParam(':dateid', $dateid);
            $stmt->bindParam(':userid',$userid);
            $stmt->bindParam(':nimtteil', $cod1);
            $stmt->bindParam(':grund', $cod2);
            $stmt->execute();
            return true;
            } catch (Exception $e) {

                return false;
            }
        }
        
        /**
         * Offene Termine eines Users abfragen
         * @param type $userid int
         * @return null|dbresult der dateid's
         */
        public function getoffeneDates($userid) {
               
            $conn = $this->connect();
            
            try {
                $result=null;
                $stmt=$conn->prepare("SELECT dateid FROM teilnehmer WHERE  (userid = :userid and nimtteil = :nimt )");
                $code='o';
                $stmt->bindParam(':userid', $userid);
                $stmt->bindParam(':nimt', $code);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                 } catch (Exception $e) {
 
                return null;
            }
        }
        
        /**
         * Sucht die Termndaten von dateid-array
         * @param type $dbresult array of dateid
         * @return null|dbresult von Terminen
         */
        public function getDatefromteilnehmerData($dbresult)
        {
            $conn = $this->connect();
            $dates=null;
            try {
                foreach($dbresult as $row)
                {

                    $result=null;
                    $stmt=$conn->prepare("SELECT * FROM dates WHERE  dateid = :dateid");
                    $stmt->bindParam(':dateid', $row['dateid']);
                    $stmt->execute();
                    $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(count($dbresult)>0)
                    {
                        $dates[]=$dbresult[0];
                    }
                }
                return $dates;
                }catch (Exception $e) {
                return null;
            }
            return null;
        }
        
        /**
         * Sucht alle User mit daten zu einem Date
         * @param type $dateid int
         * @return null|dbresult von teilnehmerdaten
         */
        public function getallTeilnehmer($dateid)  {
            
            $conn = $this->connect();
            
            try {
                $result=null;
                $stmt=$conn->prepare("SELECT userid, nimtteil, grund FROM teilnehmer WHERE  dateid = :dateid");
                $stmt->bindParam(':dateid', $dateid);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                 } catch (Exception $e) {
 
                return null;
            }
        }
        
        /**
         * Bestätigt oder lehnt Termin ab
         * @param type $userid      int user
         * @param type $dbresult    int dateid
         * @param type $text        String Anmerkung
         * @param type $cod         char b=bestätigt a=abgelehnt
         * @return boolean          ob erfolgreich
         */
        public function setTerminOkorNot($userid,$dbresult,$text,$cod)  {
            
                $conn = $this->connect();
                try {
                    $stmt=$conn->prepare("UPDATE teilnehmer SET nimtteil = :nimtteil, grund = :grund WHERE ( dateid = :dateid and userid = :userid) ");
                    $stmt->bindParam(':nimtteil', $cod);
                    $stmt->bindParam(':grund', $text);
                    $stmt->bindParam(':dateid', $dbresult);
                    $stmt->bindParam(':userid', $userid);
                    $stmt->execute();
                    return true;
                    } catch (Exception $e) {
 
                return false;
            }
            return false;
        }
        
        /**
         * Bestättigte Termin abfragen
         * @param type $userid int
         * @return null|dbresult 
         */
        public function getbestDates($userid) {
               
            $conn = $this->connect();
            
            try {
                $result=null;
          
                $stmt=$conn->prepare("SELECT dateid FROM teilnehmer WHERE  ((userid = :userid) and ( nimtteil = :nimt ))");
                $code='b';
                $stmt->bindParam(':userid', $userid);
                $stmt->bindParam(':nimt', $code);
                $stmt->execute();
                $dbresult=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($dbresult)>0)
                {
                    return $dbresult;
                }
                else 
                {
                    return null;
                }
                 } catch (Exception $e) {
                return null;
            }
        }
}
