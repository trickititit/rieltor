<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 1:51
 */

require_once "globalmessage_class.php";

class Message extends GlobalMessage {

    public function __construct()
    {
        parent::__construct("messages");
    }

}