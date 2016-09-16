<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 20.07.2016
 * Time: 10:41
 */

require_once "object_class.php";
require_once "images_class.php";

class Upload {
    private $images;
    private $objects;


    public function __construct($db) {
        $this->objects = new Object($db);
        $this->images= new Images($db);
    }

    private function getIdImage() {
        return $this->images->getLast() + 1;
    }

    private function getId() {
        return $this->objects->getLast() + 1;

    }

    /**
     *
     */
    public function UploadFile () {
        session_start();
        $ROOT = $_SERVER['DOCUMENT_ROOT'];
        $storeFolder = $ROOT . '/uploads';   //2
        $session_key = $_SESSION["session_key"];
        $obj_id = (isset($_REQUEST['objid']))?$_REQUEST['objid']:$this->getId();
        $tmp_img = (isset($_REQUEST["tmp-img"]))?$_REQUEST["tmp-img"]:0;
        if ($tmp_img == 1){
            $uploadDir = $storeFolder."/".$session_key."-".$obj_id;
            $src_folder = "/uploads/".$session_key."-".$obj_id."/";
        } else {
            $uploadDir = $storeFolder."/".$obj_id;
            $src_folder = "/uploads/".$obj_id."/";
        }
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir);
        }
        if (!empty($_FILES)) {
            //какиенить проверочки
            $img_id = $this->getIdImage();
            $img_type = $this->getTypeImg();
            $filename = $img_id . $img_type;
            $src = $uploadDir . "/" . $filename;            
            $thumb_src = $uploadDir. "/". "thumb-". $filename;
            $tempFile = $_FILES['file']['tmp_name'];
            $org_name = $_FILES['file']['name'];
            $this->images->addImage($src_folder, $img_type, $obj_id, $org_name, $filename, $tmp_img);
            move_uploaded_file($tempFile,$src); //6
            @copy($src, $thumb_src);
            /* Вызываем функцию с целью уменьшить изображение до ширины в 100 пикселей, а высоту уменьшив пропорционально, чтобы не искажать изображение */
            $this->resize($thumb_src, 348, 232); // Вызываем функцию
        }  else {
            $result  = array();
            $files = scandir($uploadDir);                 //1
            if ( false!==$files ) {
                foreach ( $files as $file ) {
                    if ( '.'!=$file && '..'!=$file && !preg_match("/^thumb-.*/", $file)) {       //2
                        $obj['name'] = $file;
                        $obj['size'] = filesize($uploadDir."/".$file);
                        $result[] = $obj;
                    }
                }
            }

            header('Content-type: text/json');              //3
            header('Content-type: application/json');
            echo json_encode($result);
        }
    }

    private function getTypeImg() {
        if ($_FILES["file"]["type"] == "image/gif") {
            return ".gif";
        } else if ($_FILES["file"]["type"] == "image/jpeg") {
            return ".jpg";
        } else if ($_FILES["file"]["type"] == "image/png") {
            return ".png";
        } else {
            return ".err";
        }

    }
        private function resize($image, $w_o = false, $h_o = false) {
            if (($w_o < 0) || ($h_o < 0)) {
                echo "Некорректные входные параметры";
                return false;
            }
            list($w_i, $h_i, $type) = getimagesize($image); // Получаем размеры и тип изображения (число)
            $types = array("", "gif", "jpeg", "png"); // Массив с типами изображений
            $ext = $types[$type]; // Зная "числовой" тип изображения, узнаём название типа
            if ($ext) {
                $func = 'imagecreatefrom'.$ext; // Получаем название функции, соответствующую типу, для создания изображения
                $img_i = $func($image); // Создаём дескриптор для работы с исходным изображением
            } else {
                echo 'Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый
                return false;
            }
            /* Если указать только 1 параметр, то второй подстроится пропорционально */
            if (!$h_o) $h_o = $w_o / ($w_i / $h_i);
            if (!$w_o) $w_o = $h_o / ($h_i / $w_i);
            $img_o = imagecreatetruecolor($w_o, $h_o); // Создаём дескриптор для выходного изображения
            imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); // Переносим изображение из исходного в выходное, масштабируя его
            $func = 'image'.$ext; // Получаем функция для сохранения результата
            return $func($img_o, $image); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции
        }
}