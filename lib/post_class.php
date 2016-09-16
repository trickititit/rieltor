<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 09.07.2016
 * Time: 20:03
 */


require_once "global_class.php";

class Post extends GlobalClass
{
    public function __construct($db)
    {
        parent::__construct("post", $db);
    }
}