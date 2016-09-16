<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 04.08.2016
 * Time: 22:49
 */
require_once "modulescontent_class.php";

class ViewObjContent extends ModulesContent {

    private $objects;
    private $images;
    private $users;
    private $comforts;
    private $comforts_;
    private $creater;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->objects = $this->object->get($this->data["id"]);//пердать id пользователя
        $this->images = $this->image->getAllOnObjID($this->data["id"]);
        $this->users = $this->user->getAll();
        $this->comforts = $this->comfort->getAll();
        $this->comforts_ = $this->object->getAllComfortsOnObj($this->data["id"]);
        $this->creater = $this->user->get($this->objects["created_id"]);
    }

    protected function getTitle()
    {
        // TODO: Implement getTitle() method.
    }

    protected function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    protected function getKeywords()
    {
        // TODO: Implement getKeywords() method.
    }

    protected function getTop()    {

        $sr["title_obj"] = $this->getTitleObj();
        $sr["time"] = "Размещено ".$this->formantDate($this->objects["date"]);
        $sr["gallery"] = $this->getGallery();
        $sr["price"] = "<span class=\"block_obj_price\">".$this->objects["obj_price"]."</span>";
        $sr["city"] = "<span class=\"block_obj_price\">".$this->objects["obj_city"]."</span>";
        $sr["add"] = "<span class=\"block_obj_price\">".$this->objects["obj_area"].", ".$this->objects["obj_address"]."</span>";
        $sr["contact"] = "<span class=\"block_obj_price\">".$this->creater["name"]." ".$this->creater["contact"]."</span>";
        $sr["comforts"] = $this->getComforts();
        $sr["desc"] = "<span class=\"block_obj_price\">".$this->objects["obj_desc"]."</span>";
        $sr["map"] = "ymaps.ready(function () {
            var myMap = window.map = new ymaps.Map('YMapsID', {
                    center: [".$this->objects["obj_geo"]."],
                    zoom: 16,
                    behaviors: ['default']

                        }),                            
                     _point = new ymaps.Placemark([".$this->objects["obj_geo"]."], {
                balloonContentBody: \"".$this->objects["obj_address"]."\"
                    });
                    myMap.geoObjects.add(_point);});";
        return $this->getReplaceTemplate($sr, "view_obj");
    }

    private function getGallery(){
        $text = "";
        for ($i = 0; $i < count($this->images); $i++) {
            $text .= "<li class=\"col-xs-6 col-sm-4 col-md-3 no_padding\"  data-src=\"../uploads/".$this->objects["id"]."/".$this->images[$i]["new_name"]."\" >
                <a href=\"\">
                    <img class=\"img-responsive\" src=\"../uploads/".$this->objects["id"]."/thumb-".$this->images[$i]["new_name"]."\">
                </a>
            </li>";
        }
        return $text;
    }

    private function formantDate($time) {
        return date("m-d H:i", $time);
    }

    private function getTitleObj(){
        $text = "";
        switch ($this->objects["obj_category"]) {
            case "1" : $text .= ($this->objects["obj_rooms"] == "Студия")?$this->objects["obj_rooms"]."-к квартира ".$this->objects["obj_square"]." м² ".$this->objects["obj_floor"]."/".$this->objects["obj_home_floors"]: $this->objects["obj_rooms"]."-к квартира ".$this->objects["obj_square"]." м² ".$this->objects["obj_floor"]."/".$this->objects["obj_home_floors"];
                break;
            case "2": $text .= $this->objects["obj_type"]." ".$this->objects["obj_house_square"]." м² с участком ".$this->objects["obj_earth_square"]." сот.";
                break;
            case "3": $text .= $this->objects["obj_type"]." типа комната в ".$this->objects["obj_rooms"]."-к  квартире ".$this->objects["obj_square"]." м² ".$this->objects["obj_floor"]."/".$this->objects["obj_home_floors"];
                break;
            default: break;
        }
        return $text;
    }

    private function getComforts(){
        $text = "";
            for ($i = 0; $i < (count($this->comforts_) / 2); $i++) {
                if (isset($this->comforts_[$i+$i])){
                    $comf = $this->comfort->get($this->comforts_[$i+$i]);
                    $comf = "<div class=\"col-md-12 no_padding\">
                            <div class=\"col-md-6 no_padding\">
                            <div class=\"comfort\"><i class=\"fa fa-check-square-o\"></i>".$comf["title"]."</div>
                            </div>";
                } else {
                    $comf = "<div class=\"col-md-12 no_padding\">
                            <div class=\"col-md-6 no_padding\">                            
                            </div>";
                }
                if (isset($this->comforts_[$i+$i+1])){
                    $comf_ = $this->comfort->get($this->comforts_[$i+$i+1]);
                    $comf_ = "<div class=\"col-md-6 no_padding\">
                            <div class=\"comfort\"><i class=\"fa fa-check-square-o\"></i>".$comf_["title"]."</div>
                            </div>
                            </div>
                            ";
                }  else {
                    $comf_ = "<div class=\"col-md-6 no_padding\">                            
                            </div>
                             </div>";
                }
                $text .= $comf.$comf_;
            }
        return $text;
    }

    protected function getMenu()
    {
        // TODO: Implement getMenu() method.
    }

    protected function getMiddle()
    {
        // TODO: Implement getMiddle() method.
    }

    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
    }
}