<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 25.07.2016
 * Time: 22:53
 */

require_once "config_class.php";
require_once "user_class.php";
require_once "object_class.php";

class doIt {
    private $config;
    private $user;
    private $data;
    private $object;
    private $user_info;
    private $comfort;


    public function __construct($db)
    {
        session_start();
        $this->comfort = new Comfort($db);
        $this->config = new Config();
        $this->user = new User($db);
        $this->object = new Object($db);
        $this->user_info =  $this->getUser();
        $this->data = $this->secureData($_REQUEST);
    }

    private function getUser(){
        $login = $_SESSION["login"];
        $password = $_SESSION["password"];
        if ($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
        else return false;
    }

    private function secureData($data){
        foreach ($data as $key => $value) {
            if (is_array($value)) $this->secureData($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }
    
    public function doInPreWork(){
        $obj_id = $this->data["id"];
        $user_id = $this->user_info["id"];
        $result = $this->object->editInPreWork($obj_id, $user_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_ADD_OBJ_IN_PRE_WORK";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_ADD_OBJ_IN_PRE_WORK";
            $_SESSION["type_message"] = "warning";
        }
    }

    public function doInWork(){
        $obj_id = $this->data["id"];
        $obj = $this->object->get($obj_id);
        $user_id = $obj["pre_working_id"];
        $result = $this->object->editInWork($obj_id, $user_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_ADD_OBJ_IN_WORK";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_ADD_OBJ_IN_WORK";
            $_SESSION["type_message"] = "warning";
        }
    }

    public function doCancelInWork(){
        $obj_id = $this->data["id"];        
        $result = $this->object->editCancelInWork($obj_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_CANCEL_IN_WORK";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_CANCEL_IN_WORK";
            $_SESSION["type_message"] = "warning";
        }
    }

    public function doCancelWork(){
        $obj_id = $this->data["id"];
        $result = $this->object->editCancelInWork($obj_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_CANCEL_WORK";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_CANCEL_WORK";
            $_SESSION["type_message"] = "warning";
        }
    }
    
    public function doPreDelete() {
        $obj_id = $this->data["id"];
        $user_id = $this->user_info["id"];
        $result = $this->object->editPreDelete($obj_id, $user_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_PRE_DELETE_OBJ";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_PRE_DELETE_OBJ";
            $_SESSION["type_message"] = "warning";
        }
    }

    public function doFavDelete() {
        $obj_id = $this->data["id"];
        $user_id = $this->user_info["id"];
        $favorites = $this->user->getAllFavoritesOnUser($user_id);
        for ($i = 0; $i < count($favorites); $i++) {
            if ($favorites[$i] == $obj_id) {
                unset($favorites[$i]);
            }
        }
        $value = implode(",", $favorites);
        $result = $this->user->deleteFavorite($user_id, $value);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_DEL_FAV";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_DEL_FAV";
            $_SESSION["type_message"] = "warning";
        }
    }

    public function doComDelete() {
        $com_id = $this->data["id"];
        $user_access_lvl = $this->user_info["access_lvl"];
        if ($this->doAccess($user_access_lvl)) {
            $result  = $this->comfort->delete($com_id);
        } else {
            $result = false;
        }
        if ($result) {
            $_SESSION["message"] = "SUCCESS_DELETE_COMFORT";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_DELETE_COMFORT";
            $_SESSION["type_message"] = "warning";
        }
    }


    public function doDelete() {
        $obj_id = $this->data["id"];        
        $result = $this->object->editDelete($obj_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_DELETE_OBJ";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_DELETE_OBJ";
            $_SESSION["type_message"] = "warning";
        }
    }

    public function doCancelDelete() {
        $obj_id = $this->data["id"];        
        $result = $this->object->editCancelDelete($obj_id);
        if ($result) {
            $_SESSION["message"] = "SUCCESS_CANCEL_DELETE_OBJ";
            $_SESSION["type_message"] = "success";
        }
        else {
            $_SESSION["message"] = "FAIL_CANCEL_DELETE_OBJ";
            $_SESSION["type_message"] = "warning";
        }
    }

    private function doAccess($access_lvl) {
        if ($access_lvl == 2) {
            return true;
        } else {
            return false;
        }
    }
}