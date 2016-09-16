<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 20.07.2016
 * Time: 10:41
 */

require_once "object_class.php";
require_once "images_class.php";

class Delete
{
    private $image;
    private $objects;

    public function __construct($db)
    {
        $this->objects = new Object($db);
        $this->image = new Images($db);
    }

    private function getIdImage() {
        return $this->image->getLast() + 1;
    }

    private function getId() {
        return $this->objects->getLast() + 1;

    }

    public function deleteFile()
    {
        if (isset($_POST['file'])) {
            session_start();
            $filename = $_POST['file'];
            $ROOT = $_SERVER['DOCUMENT_ROOT'];
            $session_key = $_SESSION["session_key"];
            $storeFolder = $ROOT . '/uploads';   //2
            $obj_id = (isset($_REQUEST['objid']))?$_REQUEST['objid']:$this->getId();
            $tmp_img = (isset($_REQUEST["tmp-img"]))?$_REQUEST["tmp-img"]:0;
            if ($tmp_img == 1){
                $uploadDir = $storeFolder."/".$session_key."-".$obj_id;
            } else {
                $uploadDir = $storeFolder."/".$obj_id;
            }
            $images = $this->getAllImage($obj_id);
            for ($i = 0; $i < count($images); $i++) {
                if ($images[$i]['org_name'] == $filename) {
                    $filename = $images[$i]['new_name'];
                    $image_id = $images[$i]['id'];
                } else if ($images[$i]['new_name'] == $filename) {
                    $image_id = $images[$i]['id'];
                }
            }
            $this->image->delete($image_id);
            unlink($uploadDir."/". $filename);
            unlink($uploadDir."/". "thumb-". $filename);
        }
    }

    private function getAllImage($id) {
        return $this->image->getAllOnObjID($id);
    }
}