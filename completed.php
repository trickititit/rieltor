<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 12.10.2016
 * Time: 0:41
 */
require_once "lib/database_class.php";
require_once "lib/object_class.php";

$db = new DataBase();
$object = new Object($db);
$objects = $object->getAll();
$now_date = time();
    for ($i = 0; $i < count($objects); $i++) {
    $obj_date = new DateTime();
    $obj_date->setTimestamp($objects[$i]["date"]);
    $obj_date->add(new DateInterval("P".(1 + $objects[$i]["activate_state"])."M"));
    if ($obj_date->getTimestamp() < $now_date) {
        $object->doCompleted($objects[$i]["id"], $objects[$i]["created_id"]);
        }
    }
