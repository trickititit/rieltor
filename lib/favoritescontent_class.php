<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 24.07.2016
 * Time: 22:47
 */
require_once "modulescabinet_class.php";

class FavoritesContent extends ModulesCabinet {

    private $favorites;
    private $fav_objs;
    private $images;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->favorites = $this->user->getAllFavoritesOnUser($this->user_info["id"]);
        $this->fav_objs = $this->getAllfavoritesObj();
        $this->images = $this->image->getAll();
    }

    protected function getTitle()
    {
        return "Избранное";
    }

    protected function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    protected function getKeywords()
    {
        // TODO: Implement getKeywords() method.
    }

    protected function getTop()
    {
        // TODO: Implement getTop() method.
    }

    protected function getMenu()
    {
        // TODO: Implement getMenu() method.
    }

    protected function getMiddle()
    {

        $sr["favorites"] = $this->getComfortTable();
        return $this->getReplaceTemplate($sr, "favorites");
    }

    private function getComfortTable(){
        $text = "";
        for ($i = 0; $i < count($this->fav_objs); $i++) {
            $type = $this->fav_objs[$i]["obj_category"];
            $deletelink = $this->config->siteAddress."?view=favorites&do=fav_del&id=".$this->fav_objs[$i]["id"];
            switch ($type) {
                case "1":
                    $title = ($this->fav_objs[$i]["obj_rooms"] == "Студия")?$this->fav_objs[$i]["obj_rooms"]." квартира": $this->fav_objs[$i]["obj_rooms"]."-к квартира";
                    $text .= "<div class=\"row margin_fav block_fav\"><div class=\"col-md-12\">";
                    $text .= "<div class=\"col-md-4\"><img src=\"".$this->getImage($this->fav_objs[$i]["id"])."\" class=\"img-responsive\"></div><div class=\"col-md-6\"><div class=\"row\"><div class=\"col-md-12\">";
                    $text .= "<a href=\"".$this->config->siteAddress."content/?id=".$this->fav_objs[$i]["id"]."\">".$title."</a></div></div><div class=\"row\"><div class=\"col-md-12 margin_fav\">";
                    $text .= "<span>".$this->fav_objs[$i]["obj_price"]." руб.</span></div></div><div class=\"row\">";
                    $text .= "<div class=\"col-md-12 margin_fav\" style=\"color: #C1C1C1\">
                        <span>Квартиры <br />
                        ".$this->fav_objs[$i]["obj_city"].", ".$this->fav_objs[$i]["obj_area"].", ".$this->fav_objs[$i]["obj_address"]."<br />
                        ".$this->formantDate($this->fav_objs[$i]["date"])." <br />
                        </span>";
                    $text .= "</div></div></div><div class=\"col-md-2\"><a href='$deletelink'><div title=\"Убрать из избранного\" class=\"btn btn-danger\">Убрать</div></a></div></div></div>";
                    break;
                case "2":
                    $title = $this->fav_objs[$i]["obj_type"];
                    $text .= "<div class=\"row margin_fav block_fav\"><div class=\"col-md-12\">";
                    $text .= "<div class=\"col-md-4\"><img src=\"".$this->getImage($this->fav_objs[$i]["id"])."\" class=\"img-responsive\"></div><div class=\"col-md-6\"><div class=\"row\"><div class=\"col-md-12\">";
                    $text .= "<a href=\"".$this->config->siteAddress."content/?id=".$this->fav_objs[$i]["id"]."\">".$title."</a></div></div><div class=\"row\"><div class=\"col-md-12 margin_fav\">";
                    $text .= "<span>".$this->fav_objs[$i]["obj_price"]." руб.</span></div></div><div class=\"row\">";
                    $text .= "<div class=\"col-md-12 margin_fav\" style=\"color: #C1C1C1\">
                        <span>Дом, дача, коттетж<br />
                        ".$this->fav_objs[$i]["obj_city"].", ".$this->fav_objs[$i]["obj_area"].", ".$this->fav_objs[$i]["obj_address"]."<br />
                        ".$this->formantDate($this->fav_objs[$i]["date"])." <br />
                        </span>";
                    $text .= "</div></div></div><div class=\"col-md-2\"><a href='$deletelink'><div title=\"Убрать из избранного\" class=\"btn btn-danger\">Убрать</div></a></div></div></div>";
                    break;
                case "3":
                    $title = $this->fav_objs[$i]["obj_type"]." в ".$this->fav_objs[$i]["obj_rooms"]."-к";
                    $text .= "<div class=\"row margin_fav block_fav\"><div class=\"col-md-12\">";
                    $text .= "<div class=\"col-md-4\"><img src=\"".$this->getImage($this->fav_objs[$i]["id"])."\" class=\"img-responsive\"></div><div class=\"col-md-6\"><div class=\"row\"><div class=\"col-md-12\">";
                    $text .= "<a href=\"".$this->config->siteAddress."content/?id=".$this->fav_objs[$i]["id"]."\">".$title."</a></div></div><div class=\"row\"><div class=\"col-md-12 margin_fav\">";
                    $text .= "<span>".$this->fav_objs[$i]["obj_price"]." руб.</span></div></div><div class=\"row\">";
                    $text .= "<div class=\"col-md-12 margin_fav\" style=\"color: #C1C1C1\">
                        <span>Комната<br />
                        ".$this->fav_objs[$i]["obj_city"].", ".$this->fav_objs[$i]["obj_area"].", ".$this->fav_objs[$i]["obj_address"]."<br />
                        ".$this->formantDate($this->fav_objs[$i]["date"])." <br />
                        </span>";
                    $text .= "</div></div></div><div class=\"col-md-2\"><a href='$deletelink'><div title=\"Убрать из избранного\" class=\"btn btn-danger\">Убрать</div></a></div></div></div>";
                    break;
                default:
                    break;
            }
        }
        return $text;
    }

    private function formantDate($time) {
        return date("m-d H:i", $time);
    }

    private function getImage($id){
        for ($i = 0; $i < count($this->images); $i++ ) {
            if ($id == $this->images[$i]["obj_id"]) {
                $result = "../uploads/".$id."/".$this->images[$i]["new_name"];
                break;
            }
        }
        $result = (isset($result))? $result:"../images/no-images.jpg";
        return $result;
        }


    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
    }

    private function getAllfavoritesObj() {
        return $this->object->getAllFavoritesOnIds($this->favorites);
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
                    <li class=\"dropdown\">
                        <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Обьекты<span class=\"caret\"></span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li><a href=\"".$this->config->siteAddress."cabinet\">Просмотр обьектов</a></li>
                            <li><a href=\"".$this->config->siteAddress."cabinet\?view=objcreate\">Добавить новый</a></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .="<li><a href=\"".$this->config->siteAddress."cabinet\?view=export\">Отчет по обьектам</a></li>";
        }
        $text .= "</ul>
                    </li>
                    <li class=\"dropdown\">
                        <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Пользователь<span class=\"caret\"></span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li><a href=\"".$this->config->siteAddress."cabinet\?view=profileedit%editprofile%\">Редактирование профиля</a></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li><a href=\"" . $this->config->siteAddress . "cabinet\?view=reg\">Добавить нового пользователя</a></li>";
            $text .= "<li><a href=\"" . $this->config->siteAddress . "cabinet\?view=profiles\">Все пользователи</a></li>";
        }
        $text .= "</ul></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li class=\"dropdown\">
                        <a class=\"dropdown - toggle\" data-toggle=\"dropdown\" href=\"#\">Сообщения<span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\" >
                            <li ><a href = \"".$this->config->siteAddress."cabinet\?view=messages\" >Просмотр сообщений</a ></li >";
            $text .= "<li><a href=\"" . $this->config->siteAddress . "cabinet\?view=add_message\" >Добавить новое сообщение</a ></li >";
            $text .= "</ul></li>";
        } else {
            $text .= "<li>
                        <a href=\"".$this->config->siteAddress."cabinet\?view=messages\">Сообщения</a>
                        </li >";
        }
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li>
                        <a href=\"".$this->config->siteAddress."cabinet\?view=comfort\">Удобства</a>
                    </li>";
        }
        $text .="<li class='active'>
                        <a href=\"".$this->config->siteAddress."cabinet\?view=favorites\">Избранное</a>
                    </li>
                </ul>";
        return $text;
    }
}