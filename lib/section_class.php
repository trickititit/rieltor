<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 09.07.2016
 * Time: 20:05
 */

require_once "global_class.php";

class Section extends GlobalClass
{
    public function __construct($db)
    {
        parent::__construct("section", $db);
    }
}