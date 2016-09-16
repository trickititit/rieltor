<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 1:45
 */

require_once "config_class.php";

abstract class GlobalMessage {
    private $data;

    public function __construct($file)
    {
        $config = new Config();
        $this->data = parse_ini_file($config->dir_text.$file.".ini");
    }

    public function getTitle($name) {
        return $this->data[$name."_TITLE"];
    }

    public function getText($name) {
        return $this->data[$name."_TEXT"];
    }
}