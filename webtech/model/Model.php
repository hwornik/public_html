<?php
/**
 * @copyright (c) 2013, Wornik Hans <hans@wornik.eu>
 *
 * @license This Software is licensed under the Open Public License
 * @license http://fedoraproject.org/wiki/Licensing/Open_Public_License
 * 
 */
require_once $_SESSION['pfad'].'/model/Data.php';
/**
 * Modelvorgabe
 *
 * @author hans
 */
abstract class Model {
    
    protected $data;
    protected $validt;
    
    public function __construct() {
        $this->data= new Data();
    }
    
    public function zufallsstring($laenge)
    {
        $zeichen = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        srand(time());
        $zufallsstring = '';
        for($i=0;$i<$laenge;$i++)
        {
            $zufallsstring .= $zeichen[rand(0, 61)];
        }
        return $zufallsstring;
    }
  
}
