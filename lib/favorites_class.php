<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 23.07.2016
 * Time: 17:24
 */
require_once "object_class.php";
require_once "user_class.php";

class Favorites
{
    private $user;
    private $objects;
    private $user_info;


    public function __construct($db)
    {
        session_start();
        $this->objects = new Object($db);
        $this->user = new User($db);
        $this->user_info = $this->getUser();
    }

    private function getUser(){
        $login = $_SESSION["login"];
        $password = $_SESSION["password"];
        if ($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
        else return false;
    }
    
    public function addFavorites(){
        $obj_id = $_REQUEST["obj_id"];
        $user_id = $this->user_info["id"];
        $do = false;
        $favorites = $this->user->getAllFavoritesOnUser($user_id);
        for ($i = 0; $i < count($favorites); $i++) {
            if ($favorites[$i] == $obj_id) {
                $do = true;
            }
        }
        if (!$do) {
            $favorites[] = $obj_id;
            $value = implode(",", $favorites);
            $this->user->addFavorite($user_id, $value);
            $result = array("id" => $obj_id);
            header('Content-type: text/json');              //3
            header('Content-type: application/json');
            echo json_encode($result);
        }
    }

    public function deleteFavorites(){
        $obj_id = $_REQUEST["obj_id"];
        $user_id = $this->user_info["id"];        
        $favorites = $this->user->getAllFavoritesOnUser($user_id);
        for ($i = 0; $i < count($favorites); $i++) {
            if ($favorites[$i] == $obj_id) {
                unset($favorites[$i]);                
            }
        }
            $value = implode(",", $favorites);
            $this->user->deleteFavorite($user_id, $value);
            $result = array("id" => $obj_id);
            header('Content-type: text/json');              //3
            header('Content-type: application/json');
            echo json_encode($result);        
    }

}
