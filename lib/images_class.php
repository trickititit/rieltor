<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 15:35
 */

require_once "global_class.php";

class Images extends GlobalClass {
    public function __construct($db)
    {
        parent::__construct("images", $db);
    }

    public function addImage ($src_folder, $type, $obj_id, $org_name, $new_name, $tmp_img) {
        return $this->add(array("src_folder" => $src_folder, "type" => $type, "obj_id" => $obj_id, "org_name" => $org_name, "new_name" => $new_name, "temp_img" => $tmp_img));
    }

    public function getLast() {
        return $this->getLastIDIn();
    }
    
    public function getAllOnObjID($obj_id) {
        return $this->getAllOnField("obj_id", $obj_id);
    }

    public function getTmpImg($obj_id){
        return $this->getAllOnFieldAndField("obj_id", $obj_id, "temp_img", "1");
    }
    
    public function editImage($id, $folder, $obj_id){
        return $this->edit($id, array("src_folder" => $folder, "obj_id" => $obj_id, "temp_img" => 0));
    }

}