<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 11.07.2016
 * Time: 21:18
 */

    require_once "modules_class.php";

class EditObjContent extends Modules {

    private $obj;
    private $comforts;
    private $selectedComforts;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->obj = (isset($this->data["id"]))? $this->object->getObjOnId($this->data["id"]): "";
        $this->comforts = $this->comfort->getAll();
        $this->selectedComforts = $this->object->getAllComfortsOnObj($this->data["id"]);
    }

    protected function getTitle()
    {
        return "Редактирование объект";
    }

    protected function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    protected function getKeywords()
    {
        // TODO: Implement getKeywords() method.
    }

    protected function getMenu()
    {
        // TODO: Implement getMenu() method.
    }

    private function getComforts(){
        
        $text = "";
        for ($i = 0; $i < count($this->comforts); $i++) {
            $martch = false;
            for ($g = 0; $g < count($this->selectedComforts); $g++) {
                if ($this->comforts[$i]["id"] == $this->selectedComforts[$g]) $martch = true;
            }
            if ($martch) {
                $text .= "<label><input checked type=\"checkbox\" value=\"".$this->comforts[$i]["id"]."\" name=\"comfort-".$this->comforts[$i]["id"]."\" >".$this->comforts[$i]["title"]."</label>";
            } else {
                $text .= "<label><input type=\"checkbox\" value=\"".$this->comforts[$i]["id"]."\" name=\"comfort-".$this->comforts[$i]["id"]."\" >".$this->comforts[$i]["title"]."</label>";
            }
        }
        return $text;

    }

    protected function getMiddle()
    {
        $sr["message"] = $this->getMessage();
        $sr["comforts"] = $this->getComforts();
        $sr["script"] = $this->getScript($this->obj["obj_category"]);
        $sr["obj_id"] = $this->obj["id"];
        return $this->getReplaceTemplate($sr, "obj_edit");
    }

    private function getScript($type) {
        switch ($type) {
            case "1": $text = "$(document).ready(function() {
                    $('#type_ select').val(1);
                    $('#deal select').val(\"".$this->obj["obj_deal"]."\");
                    $('#obj_form_1 select').val(\"".$this->obj["obj_type"]."\");
                    $('#city_ select').val(\"".$this->obj["obj_city"]."\");
                    ".$this->getAreaOnCity($this->obj["obj_city"])."
                    $('#address input').val(\"".$this->obj["obj_address"]."\");
                    $('#room select').val(\"".$this->obj["obj_rooms"]."\");
                    $('#build_type_1 select').val(\"".$this->obj["obj_build_type"]."\");
                    $('#floor select').val(\"".$this->obj["obj_floor"]."\");
                    $('#home_floors_1 select').val(\"".$this->obj["obj_home_floors"]."\");
                    $('#square input').val(\"".$this->obj["obj_square"]."\");
                    $('#kadastr input').val(\"".$this->obj["obj_kadastr"]."\");
                    $('#desc textarea').val(\"".$this->obj["obj_desc"]."\");
                    $('#price input').val(\"".$this->obj["obj_price"]."\");
                    $('#doplata input').val(\"".$this->obj["obj_doplata"]."\");                    
                    $('#client_contact input').val(\"".$this->obj["obj_client_contact"]."\");
                    $('#hotelki textarea').val(\"".$this->obj["obj_hotelki"]."\");
                    $('#comment textarea').val(\"".$this->obj["obj_desc_short"]."\");
                    $('#price_square input').val(\"".$this->obj["obj_price_square"]."\");
                    $('#obj_id').val(".$this->obj["id"]."); 
                    $('#obj-id').val(".$this->obj["id"]."); 
                    $(\"#type_ option\").not(\"[value=1]\").attr(\"disabled\", \"disabled\");
        });";
                break;
            case "2": $text = "$(document).ready(function() {
                    $('#obj_form_1').hide();
                    $('#room').hide();
                    $('#build_type_1').hide();
                    $('#floor').hide();
                    $('#home_floors_1').hide();
                    $('#square').hide();
                    $('#obj_form_3').hide();
                    $('#earth_square').show();
                    $('#distance').show();
                    $('#house_square').show();
                    $('#build_type_2').show();
                    $('#obj_form_2').show();
                    $('#home_floors_2').show();
                    $('#type_ select').val(2);                    
                    $('#deal select').val(\"".$this->obj["obj_deal"]."\");
                    $('#obj_form_2 select').val(\"".$this->obj["obj_type"]."\");
                    $('#city_ select').val(\"".$this->obj["obj_city"]."\");
                    ".$this->getAreaOnCity($this->obj["obj_city"])."
                    $('#address input').val(\"".$this->obj["obj_address"]."\");
                    $('#home_floors_2 select').val(\"".$this->obj["obj_home_floors"]."\");
                    $('#build_type_2 select').val(\"".$this->obj["obj_build_type"]."\");
                    $('#distance select').val(\"".$this->obj["obj_distance"]."\");
                    $('#earth_square input').val(\"".$this->obj["obj_earth_square"]."\");
                    $('#house_square input').val(\"".$this->obj["obj_house_square"]."\");
                    $('#kadastr input').val(\"".$this->obj["obj_kadastr"]."\");
                    $('#desc textarea').val(\"".$this->obj["obj_desc"]."\");
                    $('#price input').val(\"".$this->obj["obj_price"]."\");
                    $('#doplata input').val(\"".$this->obj["obj_doplata"]."\");                    
                    $('#client_contact input').val(\"".$this->obj["obj_client_contact"]."\");
                    $('#hotelki textarea').val(\"".$this->obj["obj_hotelki"]."\");
                    $('#comment textarea').val(\"".$this->obj["obj_desc_short"]."\");
                    $('#price_square input').val(\"".$this->obj["obj_price_square"]."\");
                    $('#obj_id').val(".$this->obj["id"].");
                    $('#obj-id').val(".$this->obj["id"]."); 
                    $(\"#type_ option\").not(\"[value=2]\").attr(\"disabled\", \"disabled\");
        });";
                break;
            case "3": $text = "$(document).ready(function() {
                    $('#obj_form_3').show();
                    $('#obj_form_1').hide();                    
                    $('#type_ select').val(3);
                    $('#deal select').val(\"".$this->obj["obj_deal"]."\");
                    $('#obj_form_3 select').val(\"".$this->obj["obj_type"]."\");
                    $('#city_ select').val(\"".$this->obj["obj_city"]."\");
                    ".$this->getAreaOnCity($this->obj["obj_city"])."
                    $('#address input').val(\"".$this->obj["obj_address"]."\");
                    $('#room select').val(\"".$this->obj["obj_rooms"]."\");
                    $('#build_type_1 select').val(\"".$this->obj["obj_build_type"]."\");
                    $('#floor select').val(\"".$this->obj["obj_floor"]."\");
                    $('#home_floors_1 select').val(\"".$this->obj["obj_home_floors"]."\");
                    $('#square input').val(\"".$this->obj["obj_square"]."\");
                    $('#kadastr input').val(\"".$this->obj["obj_kadastr"]."\");
                    $('#desc textarea').val(\"".$this->obj["obj_desc"]."\");
                    $('#price input').val(\"".$this->obj["obj_price"]."\");
                    $('#doplata input').val(\"".$this->obj["obj_doplata"]."\");                    
                    $('#client_contact input').val(\"".$this->obj["obj_client_contact"]."\");
                    $('#hotelki textarea').val(\"".$this->obj["obj_hotelki"]."\");
                    $('#comment textarea').val(\"".$this->obj["obj_desc_short"]."\");
                    $('#price_square input').val(\"".$this->obj["obj_price_square"]."\");
                    $('#obj_id').val(".$this->obj["id"].");
                    $('#obj-id').val(".$this->obj["id"]."); 
                    $(\"#type_ option\").not(\"[value=3]\").attr(\"disabled\", \"disabled\");
        });";
                break;
            default: break;
        }
        $text .= "
                    ymaps.ready(function () {
            var myMap = window.map = new ymaps.Map('YMapsID', {
                    center: [".$this->obj["obj_geo"]."],
                    zoom: 16,
                    behaviors: ['default']

                        }),
                    searchControl = new SearchAddress(myMap, $('form'));        
                     _point = new ymaps.Placemark([".$this->obj["obj_geo"]."], {
                balloonContentBody: \"".$this->obj["obj_address"]."\"
                    });
                    myMap.geoObjects.add(_point);});";

        return $text;
    }

    private function getAreaOncity($city) {
        if ($city == "Волгоград") {
            $script = " $('#obj_area_1 select').val(\"".$this->obj["obj_area"]."\")";
        } else {
            $script = "$('#obj_area_1').hide();
                       $('#obj_area_2').show();
                       $('#obj_area_2 select').val(\"".$this->obj["obj_area"]."\")";
        }
        return $script;
    }

    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
    }

    protected function getTop()
    {
        
    }

    protected function getNavMenu()
    {
//        $active = array();
//        switch ($this->data["view"]) {
//            case "objcreate": $active[0] = "active";
//                break;
//            case "objedit": $active[0] = "active";
//                break;
//            case "export": $active[0] = "active";
//                break;
//            case "reg": $active[1] = "active";
//                break;
//            case "profileedit": $active[1] = "active";
//                break;
//            case "comfort": $active[2] = "active";
//                break;
//            case "favorites": $active[3] = "active";
//                break;
//            default: $active[0] = "active";
//                break;
//        }
        $text = "<ul class=\"nav nav-pills margin_bottom\">
                    <li class=\"dropdown active\">
                        <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Обьекты<span class=\"caret\"></span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li><a href=\"".$this->config->siteAddress."\">Просмотр обьектов</a></li>
                            <li><a href=\"".$this->config->siteAddress."?view=objcreate\">Добавить новый</a></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .="<li><a href=\"".$this->config->siteAddress."?view=export\">Отчет по обьектам</a></li>";
        }
        $text .= "</ul>
                    </li>
                    <li class=\"dropdown\">
                        <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Пользователь<span class=\"caret\"></span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li><a href=\"".$this->config->siteAddress."?view=profileedit%editprofile%\">Редактирование профиля</a></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li><a href=\"" . $this->config->siteAddress . "?view=reg\">Добавить нового пользователя</a></li>";
            $text .= "<li><a href=\"" . $this->config->siteAddress . "?view=profiles\">Все пользователи</a></li>";
        }
        $text .= "</ul>
                    </li>
                    <li>
                        <a href=\"#\">Сообщения</a>
                    </li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li>
                        <a href=\"".$this->config->siteAddress."?view=comfort\">Удобства</a>
                    </li>";
        }
        $text .="<li>
                        <a href=\"".$this->config->siteAddress."?view=favorites\">Избранное</a>
                    </li>
                </ul>";
        return $text;
    }
}