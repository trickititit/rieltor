<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 15:35
 */

require_once "global_class.php";

class AdmMenu extends GlobalClass {
    public function __construct($db)
    {
        parent::__construct("adm_menu", $db);
    }
    
}