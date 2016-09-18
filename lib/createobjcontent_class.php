<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 11.07.2016
 * Time: 21:19
 */

require_once "modules_class.php";

class CreateObjContent extends Modules {
    
    private $comforts;
    
    public function __construct($db)
    {
        parent::__construct($db);
        $this->comforts = $this->comfort->getAll();
    }

    protected function getTitle()
    {
        return "Создание объекта";
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

    }

    protected function getMiddle()
    {
        $rand_int = rand(1,1000);
        $sr["comforts"] = $this->getComforts();
        $sr["message"] = $this->getMessage();
        $sr["obj_id"] = $this->object->getLastIDIn() + 1;
        $sr["script"] = "$(document).ready(function() {
        $('#obj-id').val(".$rand_int.");
        $('#obj_id').val(".$rand_int.");
        $('#tmp-img').val(1);
        });";
        return $this->getReplaceTemplate($sr, "obj_create");
    }

    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
    }

    protected function getTop()
    {
        // TODO: Implement getTop() method.
    }
    
    private function getComforts(){
        $text = "";
        for ($i = 0; $i < count($this->comforts); $i++) {
            $text .= "<label><input type=\"checkbox\" value=\"".$this->comforts[$i]["id"]."\" name=\"comfort-".$this->comforts[$i]["id"]."\" >".$this->comforts[$i]["title"]."</label>";
        }
        return $text;
        
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