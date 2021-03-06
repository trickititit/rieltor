<?php

/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 09.07.2016
 * Time: 20:01
 */

require_once "global_class.php";

class Object extends GlobalClass
{
    public function __construct($db)
    {
        parent::__construct("objects", $db);
    }

    public function getAllSortDate() {
        return $this->getAll("id", false);
    }    
    
    //COUNT

    public function getCountAll(){
        return $this->getCountOnField("deleted_id", "0");
    }
    
    public function getCountMy($user_id) {
        return $this->getCountOnFieldAndOnField("created_id", $user_id, "deleted_id", "0");
    }

    public function getCountInWork($user_id) {
        return $this->getCountOnFieldAndOnField("working_id", $user_id, "deleted_id", "0");
    }

    public function getCountCompleted($user_id) {
        return $this->getCountOnFieldAndOnField("completed_id", $user_id, "deleted_id", "0");
    }

    public function getCountPreWorking() {
        return $this->getCountOnFieldAndNotField("deleted_id", "0", "pre_working_id", "0");
    }
    
    public function getCountDeleted() {
        return $this->getCountOnNoField("deleted_id", "0");
    }

    //OBJ

    public function getAllObj(){
        return $this->getAllOnField("deleted_id", "0", "date", false);
    }
    
    public function getDeleted(){
        return $this->getAllOnNoField("deleted_id", "0", "date", false);
    }

    public function getMy($user_id){
        return $this->getAllOnFieldAndField("created_id", $user_id, "deleted_id", "0", "date", false);
    }

    public function getInWork($user_id){
        return $this->getAllOnFieldAndField("working_id", $user_id, "deleted_id", "0", "date", false);
    }

    public function getCompleted($user_id){
        return $this->getAllOnFieldAndField("completed_id", $user_id, "deleted_id", "0", "date", false);
    }

    public function getPreWorking(){
        return $this->getAllOnFieldAndNotField("deleted_id", "0", "pre_working_id", "0", "date", false);
    }


    public function editInWork($obj_id, $user_id){
        return $this->edit($obj_id, array("created_id" => $user_id,"working_id" => $user_id, "pre_working_id" => "0"));
    }

    public function editCancelInWork($obj_id){
        return $this->edit($obj_id, array("working_id" => "0", "pre_working_id" => "0"));
    }

    public function editInPreWork($obj_id, $user_id){
        return $this->edit($obj_id, array("pre_working_id" => $user_id));
    }

    public function editPreDelete($obj_id, $user_id){
        return $this->edit($obj_id, array("deleted_id" => $user_id));
    }

    public function editCancelDelete($obj_id){
        return $this->edit($obj_id, array("deleted_id" => "0"));
    }
    
    public function editDelete($obj_id){
        return $this->delete($obj_id);
    }
    
    public function getAllFavoritesOnIds($arrayids){
        return $this->getAllOnIds($arrayids);
    }    
    
    
    public function getObjOnId($id) {
        return $this->get($id);
    }

    public function addObjType_1 ($comment, $comforts, $data, $geo, $type, $deal, $form, $city, $area, $address, $room, $floor, $build_type, $home_floors, $square, $kadastr, $desc, $price_square, $price, $doplata, $contacts, $created_id) {
        if (!$this->checkValidObj()) return false;
        return $this->add(array("obj_desc_short" => $comment, "obj_comforts" => $comforts, "date" => $data,"obj_geo" => $geo, "obj_category" => $type, "obj_deal" => $deal, "obj_type" => $form, "obj_city" => $city, "obj_area" => $area, "obj_address" => $address, "obj_rooms" => $room, "obj_build_type" => $build_type, "obj_floor" => $floor, "obj_square" => $square, "obj_home_floors" => $home_floors, "obj_kadastr" => $kadastr, "obj_desc" => $desc, "obj_price_square" => $price_square, "obj_price" => $price, "obj_doplata" => $doplata, "obj_client_contact" => $contacts, "created_id" => $created_id));
    }

    public function addObjType_2 ($comment, $comforts, $data, $geo, $type, $deal, $form, $city, $area, $address, $distance, $earth_square, $build_type, $home_floors, $square, $kadastr, $desc, $price_square, $price, $doplata,$contacts, $created_id) {
        if (!$this->checkValidObj()) return false;
        return $this->add(array("obj_desc_short" => $comment, "obj_comforts" => $comforts, "date" => $data,"obj_geo" => $geo, "obj_category" => $type, "obj_deal" => $deal, "obj_type" => $form, "obj_city" => $city, "obj_area" => $area, "obj_address" => $address, "obj_distance" => $distance, "obj_build_type" => $build_type, "obj_earth_square" => $earth_square, "obj_house_square" => $square, "obj_home_floors" => $home_floors, "obj_kadastr" => $kadastr, "obj_desc" => $desc, "obj_price_square" => $price_square, "obj_price" => $price, "obj_doplata" => $doplata, "obj_client_contact" => $contacts, "created_id" => $created_id));
    }

    public function editObjType_2 ($comment, $comforts, $id, $type, $deal, $form, $city, $area, $address, $distance, $earth_square, $build_type, $home_floors, $square, $kadastr, $desc, $price_square, $price, $doplata, $contacts) {
        if (!$this->checkValidObj()) return false;
        return $this->edit($id, array("obj_desc_short" => $comment, "obj_comforts" => $comforts, "obj_category" => $type, "obj_deal" => $deal, "obj_type" => $form, "obj_city" => $city, "obj_area" => $area, "obj_address" => $address, "obj_distance" => $distance, "obj_build_type" => $build_type, "obj_earth_square" => $earth_square, "obj_house_square" => $square, "obj_home_floors" => $home_floors, "obj_kadastr" => $kadastr, "obj_desc" => $desc, "obj_price_square" => $price_square, "obj_price" => $price, "obj_doplata" => $doplata, "obj_client_contact" => $contacts));
    }
    
    public  function editObjType_1 ($comment, $comforts, $id, $type, $deal, $form, $city, $area, $address, $room, $floor, $build_type, $home_floors, $square, $kadastr, $desc, $price_square, $price, $doplata, $contacts) {
        if (!$this->checkValidObj()) return false;
        return $this->edit($id, array("obj_desc_short" => $comment, "obj_comforts" => $comforts, "obj_category" => $type, "obj_deal" => $deal, "obj_type" => $form, "obj_city" => $city, "obj_area" => $area, "obj_address" => $address, "obj_rooms" => $room, "obj_build_type" => $build_type, "obj_floor" => $floor, "obj_square" => $square, "obj_home_floors" => $home_floors, "obj_kadastr" => $kadastr, "obj_desc" => $desc, "obj_price_square" => $price_square, "obj_price" => $price, "obj_doplata" => $doplata, "obj_client_contact" => $contacts));
    }

    public function searchObj ($fieldsandvalues) {
        if (!$this->checkValidObj()) return false;
        return $this->search($fieldsandvalues);
    }

    private function checkValidObj(){
        return true;
    }
    
    public function getLast() {
        return $this->getLastIDIn();
    }

    public function delete($id)
    {
        return parent::delete($id);
    }

    public function getAllComfortsOnObj($id) {
        $comfortsString = $this->getField("obj_comforts", "id", $id);
        if ($comfortsString != "") {
            return explode(",", $comfortsString);
        } else {
            return false;
        }

    }
    
    

}