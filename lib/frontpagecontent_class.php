<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 11:32
 */

require_once "modules_class.php";

class FrontPageContent extends Modules {

    private $page;
    private $objects;
    private $menu;
    private $link;
    private $images;
    private $users;
    private $favorites;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->objects = $this->getObjectsOnType($this->user_info["id"]);//пердать id пользователя
        $this->menu = $this->adm_menu->getAll();
        $this->images = $this->image->getAll();
        $this->page = (isset($this->data["page"]))? $this->data["page"]: 1;
        $this->link = (isset($this->data["typepage"]))? $this->config->siteAddress."?typepage=".$this->data["typepage"]: $this->config->siteAddress;
        $this->users = $this->user->getAll();
        $this->favorites = $this->user->getAllFavoritesOnUser($this->user_info["id"]);
    }

    protected function getMenu()
    {
        $text = "<ul class=\"nav nav-tabs margin_top\">";
        for ($i = 0; $i < count($this->menu); $i++ ){
            $label = ($this->menu[$i]["label"] == "all")? "": "?typepage=".$this->menu[$i]["label"];
            if (($this->menu[$i]["label"] == "pre_working" && $this->user_info["access_lvl"] != 2) || ($this->menu[$i]["label"] == "deleted" && $this->user_info["access_lvl"] != 2)) {
                continue;
            }
            $data = (isset($this->data["typepage"]))? $this->data["typepage"]: "all";
            if ($data == $this->menu[$i]["label"]) $sr["active"] = "class=\"active\"";
            else $sr["active"] = "";
            $sr["title"] = $this->menu[$i]["title"];
            $sr["link"] = $this->config->siteAddress.$label;
            switch ($this->menu[$i]["label"]) {
                case "all": $sr["count"] = $this->object->getCountAll();
                    break;
                case "my": $sr["count"] = $this->object->getCountMy($this->user_info["id"]);
                    break;
                case "in_work": $sr["count"] = $this->object->getCountInWork($this->user_info["id"]);
                    break;
                case "pre_working": $sr["count"] = $this->object->getCountPreWorking();
                    break;
                case "completed": $sr["count"] = $this->object->getCountCompleted($this->user_info["id"]);
                    break;
                case "deleted": $sr["count"] = $this->object->getCountDeleted();
                    break;
                default: break;
            }
            $text .= $this->getReplaceTemplate($sr, "adm_menu");
        }
        $link = "";
        $link .= "/?";
        if (isset($this->data)) {
            foreach ($this->data as $key => $value) {
                if ($key == "order") {
                    continue;
                }
                $link .= $key."=".$value."&";
            }
        }
        $values = array($link."order=date", $link."order=priceup", $link."order=pricedown");
        $valuess = array("date","priceup","pricedown");
        $val = array();
        for ($i = 0; $i < 3; $i++) {
            if ($this->data["order"] == $valuess[$i]) {
                $val[$i] = "value=\"$values[$i]\" selected";
            } else {
                $val[$i] = "value=\"".$values[$i]."\"";
            }
        }
        $text .= "
<select onchange=\"window.location.href=this.options[this.selectedIndex].value\" id=\"order\" name=\"order\">
<option ".$val[0].">По дате</option>
<option ".$val[1].">Дешевле</option>
<option ".$val[2].">Дороже</option>
</select>";
        $text .= "</ul>";
        return $text;
    }

    protected function getMiddle()
    {
        $sr["post_table"] = $this->getTable();
        return $this->getReplaceTemplate($sr, "middle");
    }
    
    protected function getBottom()
    {
        if ($this->data["search"] || $this->data["order"]) {
            $new_link = $this->config->siteAddress. "?";
            foreach ($this->data as $key => $value) {
                if($key != "page"){
                    $new_link .= $key ."=".$value."&";
                }
            }
            $new_link = substr($new_link, 0, -1);
            $this->link = $new_link;
        }
        $page = (isset($this->data["page"]))? $this->data["page"]:1;
        return $this->getPagination(count($this->objects), $this->config->count_obj, $this->link, $page);
    }

    private function getObjectsOnType($user_id) {
        $data = $this->data["typepage"];
        if ($this->data["order"] == "date") {
            $order = "date";
            $up = false;
        } else if ($this->data["order"] == "pricedown") {
            $this->object->order = "obj_price";
            $this->object->up = false;
        } else if ($this->data["order"] == "priceup") {
            $this->object->order = "obj_price";
            $this->object->up = true;
        } else {
            $this->object->order = "date";
            $this->object->up = false;
        }
        if ($this->data["search"]) {
            $obj = $this->search();
        } else {
            switch ($data) {
                case "my": $obj = $this->object->getMy($user_id);
                    break;
                case "in_work": $obj = $this->object->getInWork($user_id);
                    break;
                case "pre_working": $obj = $this->object->getPreWorking();
                    break;
                case "completed": $obj = $this->object->getCompleted($user_id);
                    break;
                case "deleted": $obj = $this->object->getDeleted();
                    break;
                default: $obj = $this->object->getAllOnField_("deleted_id", "0");
            }
        }
        return $obj;
    }

    private function formantDate($time) {
        return date("d.m.Y", $time);
    }

    private function getTable() {
        $start = ($this->page - 1) * $this->config->count_obj;
        $end = (count($this->objects) > $start + $this->config->count_obj)? $start + $this->config->count_obj: count($this->objects);
        for ($i = $start; $i < $end; $i++ ){
            $obj_type = $this->objects[$i]["obj_category"];
            $set_image = false;
            for ($g = 0; $g < count($this->images); $g++ ) {
                if ($this->objects[$i]["id"] == $this->images[$g]["obj_id"]) {
                    $set_image = true;
                }
            }
            switch ($obj_type) {
                case "1":  $sr["obj_photo"] = ($set_image)?"<i class=\"fa fa-camera fa-lg\"></i>": "";
                           $sr["obj_data"] = $this->formantDate($this->objects[$i]["date"]);
                           $sr["obj_square"] = $this->objects[$i]["obj_square"]." м²";
                           $sr["obj_form"] = $this->objects[$i]["obj_floor"]."/".$this->objects[$i]["obj_home_floors"]." эт.";
                    $sr["obj_title"] = ($this->objects[$i]["obj_rooms"] == "Студия")?$this->objects[$i]["obj_rooms"]." квартира": $this->objects[$i]["obj_rooms"]."-к квартира";
                    $sr["obj_address"] = $this->objects[$i]["obj_city"].", ".$this->objects[$i]["obj_area"].", ".$this->objects[$i]["obj_address"];
                    $sr["obj_comment"] = $this->objects[$i]["obj_desc"];
                    $sr["obj_short_desc"] = $this->objects[$i]["obj_desc_short"];
                    $sr["obj_doplata"] = number_format($this->objects[$i]["obj_doplata"])." руб.";
                    $sr["obj_price"] = number_format($this->objects[$i]["obj_price"])." руб.";
                    $sr["obj_deal"] = ($this->objects[$i]["obj_deal"] == "Продажа")?"<i class=\"fa fa-shopping-cart fa-lg\"></i>":"<i class=\"fa fa-retweet fa-lg\"></i>";
                    $sr["obj_client_contact"] = $this->getContacts($this->objects[$i]["obj_client_contact"], $this->objects[$i]["created_id"], $this->objects[$i]["working_id"]);
                    $sr["link"] = $this->config->siteAddress."content/?id=".$this->objects[$i]["id"];
                    $sr["obj_action"] = $this->getActions($this->objects[$i]["id"], $this->objects[$i]["working_id"], $this->objects[$i]["pre_working_id"], $this->objects[$i]["created_id"], $this->objects[$i]["deleted_id"]);
                    break;
                case "2": $sr["obj_photo"] = ($set_image)?"<i class=\"fa fa-camera fa-lg\"></i>": "";
                    $sr["obj_data"] = $this->formantDate($this->objects[$i]["date"]);
                    $sr["obj_square"] = $this->objects[$i]["obj_house_square"]." м²";
                    $sr["obj_form"] = "на участке ".$this->objects[$i]["obj_earth_square"]." сот.";
                    $sr["obj_title"] = $this->objects[$i]["obj_type"];
                    $sr["obj_address"] = $this->objects[$i]["obj_city"].", ".$this->objects[$i]["obj_area"].", ".$this->objects[$i]["obj_address"];
                    $sr["obj_comment"] = $this->objects[$i]["obj_desc"];
                    $sr["obj_short_desc"] = $this->objects[$i]["obj_desc_short"];
                    $sr["obj_doplata"] = number_format($this->objects[$i]["obj_doplata"])." руб.";
                    $sr["obj_price"] = number_format($this->objects[$i]["obj_price"])." руб.";
                    $sr["obj_deal"] = ($this->objects[$i]["obj_deal"] == "Продажа")?"<i class=\"fa fa-shopping-cart fa-lg\"></i>":"<i class=\"fa fa-retweet fa-lg\"></i>";
                    $sr["obj_client_contact"] = $this->getContacts($this->objects[$i]["obj_client_contact"], $this->objects[$i]["created_id"], $this->objects[$i]["working_id"]);
                    $sr["link"] = $this->config->siteAddress."content/?id=".$this->objects[$i]["id"];
                    $sr["obj_action"] = $this->getActions($this->objects[$i]["id"], $this->objects[$i]["working_id"], $this->objects[$i]["pre_working_id"], $this->objects[$i]["created_id"], $this->objects[$i]["deleted_id"]);
                    break;
                case "3": $sr["obj_photo"] = ($set_image)?"<i class=\"fa fa-camera fa-lg\"></i>": "";
                    $sr["obj_data"] = $this->formantDate($this->objects[$i]["date"]);
                    $sr["obj_square"] = $this->objects[$i]["obj_square"]." м²";
                    $sr["obj_form"] = $this->objects[$i]["obj_floor"]."/".$this->objects[$i]["obj_home_floors"]." эт.";
                    $sr["obj_title"] = "Комната в ".$this->objects[$i]["obj_rooms"]."-к";
                    $sr["obj_address"] = $this->objects[$i]["obj_city"].", ".$this->objects[$i]["obj_area"].", ".$this->objects[$i]["obj_address"];
                    $sr["obj_comment"] = $this->objects[$i]["obj_desc"];
                    $sr["obj_short_desc"] = $this->objects[$i]["obj_desc_short"];
                    $sr["obj_doplata"] = number_format($this->objects[$i]["obj_doplata"])." руб.";
                    $sr["obj_price"] = number_format($this->objects[$i]["obj_price"])." руб.";
                    $sr["obj_deal"] = ($this->objects[$i]["obj_deal"] == "Продажа")?"<i class=\"fa fa-shopping-cart fa-lg\"></i>":"<i class=\"fa fa-retweet fa-lg\"></i>";
                    $sr["obj_client_contact"] = $this->getContacts($this->objects[$i]["obj_client_contact"], $this->objects[$i]["created_id"], $this->objects[$i]["working_id"]);
                    $sr["link"] = $this->config->siteAddress."content/?id=".$this->objects[$i]["id"];
                    $sr["obj_action"] = $this->getActions($this->objects[$i]["id"], $this->objects[$i]["working_id"], $this->objects[$i]["pre_working_id"], $this->objects[$i]["created_id"], $this->objects[$i]["deleted_id"]);
                    break;
            }
            $text .= $this->getReplaceTemplate($sr, "obj_table");
        }
        return $text;
    }

    private function getContacts($contact, $created_id, $work){
        if (($this->user_info["trust"] == 1 || $this->user_info["id"] == $created_id)) {
            if (($work == 0 || $this->user_info["id"] == $work) || $this->user_info["access_lvl"] == 2) {
                $contacts = $contact; 
            } else {
                for ($i = 0; $i < count($this->users); $i++) {
                    if ($this->users[$i]["id"] ==  $created_id) {
                        $contacts = $this->users[$i]["name"]." ".$this->users[$i]["contact"];
                    }
                }
            }
        } else {
            for ($i = 0; $i < count($this->users); $i++) {
                if ($this->users[$i]["id"] ==  $created_id) {
                    $contacts = $this->users[$i]["name"]." ".$this->users[$i]["contact"];
                }
            }
        }
        return $contacts;
    }

    private function getActions($obj_id, $work, $pre_work, $created, $who_deleted) {

        $typepage = $this->data["typepage"];
        // Сделать разделение по типам страницы
        switch ($typepage) {
            case "in_work":
                $editlink = $this->config->siteAddress."?view=objedit&id=".$obj_id;
                $worklink = $this->config->siteAddress."?do=cancel_work&id=".$obj_id;
                if ($work != 0 || $pre_work != 0) {
                    $inwork = "<a href='$worklink' title='Убрать из работы'><i class=\"fa fa-gears fa-lg cancel\"></i></a>";
                } else {
                    $inwork = "<a href='$worklink' title='Убрать из работы'><i class=\"fa fa-gears fa-lg cancel\"></i></a>";
                }
                $deletelink = $this->config->siteAddress."?typepage=in_work&do=pre_delete&id=".$obj_id;
                if($created == $this->user_info["id"] || $work == $this->user_info["id"]) {
                    $delete = "<a href='$deletelink' title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></a>";
                    $edit = "<a href='$editlink' title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                } else {
                    $delete = "<i class=\"fa fa-trash fa-lg disabled\"></i>";
                    $edit = "<i class=\"fa fa-edit fa-lg disabled\"></i>";
                }
                $favorites = $this->getFavoriteLink($obj_id);
                return $edit.$inwork.$favorites.$delete;                
            case "pre_working":
                $who = $this->user->getFieldOnID($pre_work, "name");
                $acceptlink = $this->config->siteAddress."?typepage=pre_working&do=in_work&id=".$obj_id;
                $canсelllink = $this->config->siteAddress."?typepage=pre_working&do=cancel_in_work&id=".$obj_id;
                $who_pre = "<p style='color: #BABABA'>От ".$who."</p>";
                $accept = "<a href='$acceptlink' title='Подтвердить'><i class=\"fa fa-check fa-lg\"></i></a>";
                $canсell = "<a href='$canсelllink' title='Отклонить'><i class=\"fa fa-ban fa-lg\"></i></a>";
                return $who_pre.$accept.$canсell;
            case "completed":
                $acceptlink = $this->config->siteAddress."?typepage=completed&do=in_pre_work&id=".$obj_id;
                $canсelllink = $this->config->siteAddress."?typepage=completed&do=pre_delete=".$obj_id;
                $accept = "<a href='$acceptlink' title='Вернуть в работу'><i class=\"fa fa-gears fa-lg\"></i></a>";
                $canсell = "<a href='$canсelllink' title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></a>";
                return $accept.$canсell;
            case "deleted":
                $who = $this->user->getFieldOnID($who_deleted, "name");
                $acceptlink = $this->config->siteAddress."?typepage=deleted&do=delete&id=".$obj_id;
                $canсelllink = $this->config->siteAddress."?typepage=deleted&do=cancel_delete&id=".$obj_id;
                $who_pre = "<p style='color: #BABABA'>От ".$who."</p>";
                $accept = "<a href='$acceptlink' title='Удалить навсегда'><i class=\"fa fa-trash fa-lg\"></i></a>";
                $canсell = "<a href='$canсelllink' title='Восстановить'><i class=\"fa fa-reply fa-lg\"></i></a>";
                return $who_pre.$accept.$canсell;                
            default:
                $editlink = $this->config->siteAddress."?view=objedit&id=".$obj_id;
                $worklink = $this->config->siteAddress."?do=in_pre_work&id=".$obj_id;
                if ($work != 0 || $pre_work != 0) {
                    $inwork = "<i class=\"fa fa-gears fa-lg disabled\"></i>";
                } else {
                    $inwork = "<a href='$worklink' title='Взять в работу'><i class=\"fa fa-gears fa-lg\"></i></a>";
                }
                $deletelink = $this->config->siteAddress."?do=pre_delete&id=".$obj_id;
                if($created == $this->user_info["id"] || $work == $this->user_info["id"] || $this->user_info["access_lvl"] == 2) {
                    $delete = "<a href='$deletelink' title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></a>";
                    $edit = "<a href='$editlink' title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                } else {
                    $delete = "<i class=\"fa fa-trash fa-lg disabled\"></i>";
                    $edit = "<i class=\"fa fa-edit fa-lg disabled\"></i>";
                }
                $favorites = $this->getFavoriteLink($obj_id);
                return $edit.$inwork.$favorites.$delete;
        }
    }

    private function getFavoriteLink($obj_id) {
        $do = false;
        $text = "";
        for ($i = 0; $i < count($this->favorites); $i++) {
            if ($this->favorites[$i] == $obj_id) {
                $text = "<i title='Убрать из избранное' class=\"fa fa-star fa-lg favor\"><id hidden>".$obj_id."</id></i>";
                $do = true;
            }
        }

        if (!$do) {
            $text = "<i title='В избранное' class=\"fa fa-star-o fa-lg favor\"><id hidden>".$obj_id."</id></i>";
        }

        return $text;
    }

    protected function getTitle()
    {
        return "Просмотр объектов";
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
        if ($this->data["search"]) {
            $sr["script"] = "$(document).ready(function() {
            ";
            $r_1 = 0;
            $match_area_1 = array();
            $r_2 = 0;
            $match_area_2 = array();
            $roo_ = 0;
            $match_rooms = array();
            $tyy_ = 0;
            $match_type_house_1 = array();
            $ty2_ = 0;
            $match_type_house_2 = array();
            $ty3_ = 0;
            $match_type_house_3 = array();
            $rooms_title = "Количество комнат";
            $type_house_2_title = "Вид обьекта";
            $type_house_3_title = "Материал стен";
            $type_house_title = "Тип дома";
            foreach ($this->data as $key => $value) {
                if (preg_match("/^area_1.*/", $key)) {
                    echo $key;
                    for ($i = 1; $i < 9; $i++) {
                        if ($key == "area_1-".$i) {
                            $match_area_1[$r_1] = $i;
                            $r_1++;
                        }
                    }
                }
                if (preg_match("/^area_2.*/", $key)) {
                    for ($i = 1; $i < 108; $i++) {
                        if ($key == "area_2-".$i) {
                            $match_area_2[$r_2] = $i;
                            $r_2++;
                        }
                    }
                }
                if (preg_match("/^checkbox-.*/", $key)) {
                    for ($i = 1; $i < 12; $i++) {
                        if ($key == "checkbox-".$i) {
                            $match_rooms[$roo_] = $i;
                            $roo_++;
                            $rooms_title = $value;
                        }
                    }
                }
                if (preg_match("/^typeHouse_1-.*/", $key)) {
                    for ($i = 1; $i < 6; $i++) {
                        if ($key == "typeHouse_1-".$i) {
                            $match_type_house_1[$tyy_] = $i;
                            $tyy_++;
                            $type_house_title = $value;
                        }
                    }
                }
                if (preg_match("/^typeObj_2-.*/", $key)) {
                    for ($i = 1; $i < 5; $i++) {
                        if ($key == "typeObj_2-".$i) {
                            $match_type_house_2[$ty2_] = $i;
                            $ty2_++;
                            $type_house_2_title = $value;
                        }
                    }
                }
                if (preg_match("/^typeHouse_2-.*/", $key)) {
                    for ($i = 1; $i < 9; $i++) {
                        if ($key == "typeHouse_2-".$i) {
                            $match_type_house_3[$ty3_] = $i;
                            $ty3_++;
                            $type_house_3_title = $value;
                        }
                    }
                }
                if (preg_match("/^square_1_min.*/", $key)) {
                   $square_1_min = $value;
                }
                if (preg_match("/^square_1_max.*/", $key)) {
                    $square_1_max = $value;
                }
                if (preg_match("/^floor_min.*/", $key)) {
                    $floor_min = $value;
                }
                if (preg_match("/^floor_max.*/", $key)) {
                    $floor_max = $value;
                }
                if (preg_match("/^floorInObj_1_min.*/", $key)) {
                    $floorInObj_min = $value;
                }
                if (preg_match("/^floorInObj_1_max.*/", $key)) {
                    $floorInObj_max = $value;
                }
                if (preg_match("/^price_min.*/", $key)) {
                    $price_min = $value;
                }
                if (preg_match("/^price_max.*/", $key)) {
                    $price_max = $value;
                }
                if (preg_match("/^floorInObj_2_min.*/", $key)) {
                    $floorInObj_2_min = $value;
                }
                if (preg_match("/^floorInObj_2_max.*/", $key)) {
                    $floorInObj_2_max = $value;
                }
                if (preg_match("/^square_2_min.*/", $key)) {
                    $square_2_min = $value;
                }
                if (preg_match("/^square_2_max.*/", $key)) {
                    $square_2_max = $value;
                }

                if (preg_match("/^square_earth_min.*/", $key)) {
                    $square_earth_min = $value;
                }
                if (preg_match("/^square_earth_max.*/", $key)) {
                    $square_earth_max = $value;
                }

                if (preg_match("/^distance_min.*/", $key)) {
                    $distance_min = $value;
                }
                if (preg_match("/^distance_max.*/", $key)) {
                    $distance_max = $value;
                }
            }
            foreach ($this->data as $key => $value) {
                switch ($key) {
                    case "type":
                        $g = 1;
                        $type = array();
                        for ($i = 0; $i < 3; $i++) {
                            if ($value == $g) {
                                $type[$i] = "value=\"$value\" selected";
                            } else {
                                $type[$i] = "value=\"".($i+1)."\"";
                            }
                          $g++;
                        }
                        $sr["type"] = "<option ".$type[0].">Квартира</option>
                                        <option ".$type[1].">Дом, дача, коттетж</option>
                                        <option ".$type[2].">Комната</option>";

                        if (count($match_rooms) > 1) $rooms_title = "Типов кол. комнат (".count($match_rooms).")";
                        $sr["rooms_title"] = "<input type=\"text\" id=\"amount-rooms\" value=\"".$rooms_title."\" readonly >";
                        if (count($match_type_house_1) > 1) $type_house_title = "Тип дома (".count($match_type_house_1).")";
                        $sr["type_house_1_title"] = "<input type=\"text\" id=\"amount-typeHouse_1\" readonly value=\"".$type_house_title."\">";
                        if (count($match_type_house_2) > 1) $type_house_2_title = "Вид обьекта (".count($match_type_house_2).")";
                        $sr["type_house_2_title"] = "<input type=\"text\" id=\"amount-formObj_2\" readonly value=\"".$type_house_2_title."\">";
                        if (count($match_type_house_3) > 1) $type_house_3_title = "Материал стен (".count($match_type_house_3).")";
                        $sr["type_house_3_title"] = "<input type=\"text\" id=\"amount-typeHouse_2\" readonly value=\"".$type_house_3_title."\">";
                        switch ($value) {
                            case "1": $sr["script"] .= "$('#amount-typeHouse_2').hide();
                                                        $('#amount-typeHouse_1').show();
                                                        $('#formObj_3').hide();
                                                        $('#amount-floor').show();
                                                        $('#amount-floorInObj_1').show();
                                                        $('#formObj_1').show();
                                                        $('#typeHouse_1').show();
                                                        $('#amount-rooms').show();
                                                        $('#amount-formObj_2').hide();
                                                        $('#amount-square_earth').hide();
                                                        $('#amount-floorInObj_2').hide();
                                                        $('#typeHouse_2').hide();
                                                        $('#amount-square_2').hide();
                                                        $('#amount-distance').hide();
                                                        $('#amount-square_1').show();";
                                break;
                            case "2": $sr["script"] .= "$('#formObj_3').hide();
                                                        $('#amount-floor').hide();
                                                        $('#amount-typeHouse_1').hide();
                                                        $('#amount-floorInObj_1').hide();
                                                        $('#formObj_1').hide();
                                                        $('#typeHouse_1').hide();
                                                        $('#amount-rooms').hide();
                                                        $('#amount-formObj_2').show();
                                                        $('#amount-typeHouse_2').show();
                                                        $('#amount-square_earth').show();
                                                        $('#amount-floorInObj_2').show();
                                                        $('#typeHouse_2').show();
                                                        $('#amount-square_2').show();
                                                        $('#amount-distance').show();
                                                        $('#amount-square_1').hide();";
                                break;
                            case "3": $sr["script"] .= "$('#amount-typeHouse_2').hide();
                                                        $('#amount-floorInObj_1').show();
                                                        $('#formObj_3').show();
                                                        $('#amount-floor').show();
                                                        $('#amount-typeHouse_1').show();
                                                        $('#formObj_1').hide();
                                                        $('#typeHouse_1').show();
                                                        $('#amount-rooms').show();
                                                        $('#amount-formObj_2').hide();
                                                        $('#amount-square_earth').hide();
                                                        $('#amount-floorInObj_2').hide();
                                                        $('#typeHouse_2').hide();
                                                        $('#amount-square_2').hide();
                                                        $('#amount-distance').hide();
                                                        $('#amount-square_1').show();";
                                break;
                            default: break;
                        }
                        break;
                    case "city":
                        $values = array("", "Волгоград", "Волжский");
                        $city = array();
                        for ($i = 0; $i < 3; $i++) {
                            if ($value == $values[$i]) {
                                $city[$i] = "value=\"$value\" selected";
                            } else {
                                $city[$i] = "value=\"".$values[$i]."\"";
                            }
                        }
                        $sr["city"] = "<option ".$city[0].">По всем городам</option>
                        <option ".$city[1].">Волгоград</option>
                        <option ".$city[2].">Волжский</option>";
                        switch ($value){
                            case "": $sr["area_1_title"] = "<input type=\"text\" id=\"amount-area_1\" readonly value=\"Район\" hidden>";
                                $sr["area_2_title"] = "<input type=\"text\" id=\"amount-area_2\" readonly value=\"Район\" hidden>";
                                $sr["script"] .= "$('#adr').css('width', '45%');";
                                break;
                            case "Волгоград": $value_1 = ($r_1 == 0)? "":"(".$r_1.")";
                                $sr["area_1_title"] = "<input type=\"text\" id=\"amount-area_1\" readonly value=\"Район ".$value_1."\">";
                                $sr["area_2_title"] = "<input type=\"text\" id=\"amount-area_2\" readonly value=\"Район\" hidden>";
                                break;
                            case "Волжский": $value_2 = ($r_2 == 0)? "":"(".$r_2.")";
                                $sr["area_1_title"] = "<input type=\"text\" id=\"amount-area_1\" readonly value=\"Район\" hidden>";
                                $sr["area_2_title"] = "<input type=\"text\" id=\"amount-area_2\" readonly value=\"Район ".$value_2."\">";
                                break;
                            default: break;
                        }
                        break;
                    case "rieltor": $rieltors = "";
                        if ($this->data["typepage"] == "all" || $this->data["typepage"] == ""){
                            $rieltors .= "<select id=\"rieltors\" name=\"rieltor\"><option value=\"\">Риелтор</option>";
                            for($i = 0; $i < count($this->users); $i++) {
                                if ($this->users[$i]["id"] == $value) {
                                    $rieltors .= "<option value=\"".$this->users[$i]["id"]."\" selected>".$this->users[$i]["name"]."</option>";
                                } else {
                                    $rieltors .= "<option value=\"".$this->users[$i]["id"]."\">".$this->users[$i]["name"]."</option>";
                                }
                            }
                            $rieltors .= "</select>";
                        }

                        $sr["rieltors"] = $rieltors;
                        break;
                    case "typedeal":
                        $g = array("", "Продажа", "Обмен");
                        $type = array();
                        for ($i = 0; $i < 3; $i++) {
                            if ($value == $g[$i]) {
                                $type[$i] = "value=\"$value\" selected";
                            } else {
                                $type[$i] = "value=\"".$g[$i]."\"";
                            }
                        }
                        $sr["typedeal"] = "<option ".$type[0].">Тип сделки</option>
                                            <option ".$type[1].">Продажа</option>
                                            <option  ".$type[2].">Обмен</option>";
                        break;
                    case "formObj_1":
                        $g = array("", "Вторичка", "Новостройка");
                        $type = array();
                        for ($i = 0; $i < 3; $i++) {
                            if ($value == $g[$i]) {
                                $type[$i] = "value=\"$value\" selected";
                            } else {
                                $type[$i] = "value=\"".$g[$i]."\"";
                            }
                        }
                        $sr["form_obj_1"] = "<option ".$type[0].">Тип объекта</option>
                                            <option ".$type[1].">Вторичка</option>
                                            <option ".$type[2].">Новостройка</option>";
                        break;
                    case "formObj_3":
                        $g = array("", "Гостиничного", "Коридорного", "Секционного", "Коммунальная");
                        $type = array();
                        for ($i = 0; $i < 5; $i++) {
                            if ($value == $g[$i]) {
                                $type[$i] = "value=\"$value\" selected";
                            } else {
                                $type[$i] = "value=\"".$g[$i]."\"";
                            }
                        }
                        $sr["form_obj_3"] = "<option ".$type[0].">Тип объекта</option>
                            <option ".$type[1].">Гостиничного</option>
                            <option ".$type[2].">Коридорного</option>
                            <option ".$type[3].">Секционного</option>
                            <option ".$type[4].">Коммунальная</option>";
                        break;
                    case "address":
                        $sr["obj_address"] = "<input name=\"address\" value=\"".$value."\" id=\"adr\" type=\"text\" placeholder=\"Адрес\" />";
                        break;
                    default: break;
                }
            }//end foreach
            $area_1 = $this->getSearchFilterArea_1();
            $area_2 = $this->getSearchFilterArea_2();
            $rooms = array();
            for ($i = 0; $i < count($match_area_1); $i++)  {
                $area_1[$match_area_1[$i]] = "name =\"area_1-".$match_area_1[$i]."\" checked";
            }
            for ($i = 0; $i < count($match_area_2); $i++)  {
                $area_2[$match_area_2[$i]] = "name =\"area_2-".$match_area_2[$i]."\" checked";
            }
            for ($i = 0; $i < count($match_rooms); $i++)  {
                $rooms[$match_rooms[$i]-1] = "checked";
            }
            for ($i = 0; $i < count($match_type_house_1); $i++)  {
                $type_house_1[$match_type_house_1[$i]-1] = "checked";
            }
            for ($i = 0; $i < count($match_type_house_2); $i++)  {
                $type_house_2[$match_type_house_2[$i]-1] = "checked";
            }
            for ($i = 0; $i < count($match_type_house_3); $i++)  {
                $type_house_3[$match_type_house_3[$i]-1] = "checked";
            }
            $sr["price"] = "<input name=\"price_min\" id=\"min-price\" value=\"".$price_min."\" type=\"number\" placeholder=\"от\"><span style=\"float: left;\">-</span>
                        <input name=\"price_max\" id=\"max-price\" value=\"".$price_max."\" type=\"number\" placeholder=\"до\">";
            $sr["script"] .= "
            });";

            $sr["slider-range-square_1_values"] = "values: [ ".$square_1_min.", ".$square_1_max." ],";
            $sr["amount-square"] = "<input type=\"number\" id=\"amount-square_min\" value=\"".$square_1_min."\" readonly name=\"square_1_min\" hidden>
                    <input type=\"number\" id=\"amount-square_max\" value=\"".$square_1_max."\" readonly name=\"square_1_max\" hidden>";
            $sr["slider-range-floor_values"] = "values: [ ".$floor_min.", ".$floor_max." ],";
            $sr["amount-floor"] = "<input type=\"number\" id=\"amount-floor_min\" value=\"".$floor_min."\" readonly name=\"floor_min\" hidden>
                    <input type=\"number\" id=\"amount-floor_max\" value=\"".$floor_max."\" readonly name=\"floor_max\" hidden>";
            $sr["slider-range-floorInObj_1_values"] = "values: [ ".$floorInObj_min.", ".$floorInObj_max." ],";
            $sr["floorInObj_1"] = "<input type=\"number\" id=\"amount-floorInObj_1_min\" value=\"".$floorInObj_min."\" readonly name=\"floorInObj_1_min\" hidden>
                    <input type=\"number\" id=\"amount-floorInObj_1_max\" value=\"".$floorInObj_min."\" readonly name=\"floorInObj_1_max\" hidden>";
            $sr["slider-range-floorInObj_2_values"] = "values: [ ".$floorInObj_2_min.", ".$floorInObj_2_max." ],";
            $sr["floorInObj_2"] = "<input type=\"number\" value=\"".$floorInObj_2_min."\"  id=\"amount-floorInObj_2_min\" readonly name=\"floorInObj_2_min\" hidden>
                    <input type=\"number\" value=\"".$floorInObj_2_max."\" id=\"amount-floorInObj_2_max\" readonly name=\"floorInObj_2_max\" hidden>";

            $sr["square_2"] = "<input type=\"number\" id=\"amount-square_2_min\" value=\"".$square_2_max."\" readonly name=\"square_2_min\" hidden>
                    <input type=\"number\" value=\"".$square_2_min."\" id=\"amount-square_2_max\" readonly name=\"square_2_max\" hidden>";
            $sr["slider-range-square_2_values"] = "values: [ ".$square_2_min.", ".$square_2_max." ],";

            $sr["slider-range-square_earth_values"] = "values: [ ".$square_earth_min.", ".$square_earth_max." ],";
            $sr["square_earth"] = "<input type=\"number\" value=\"".$square_earth_min."\" id=\"amount-square_earth_min\" readonly name=\"square_earth_min\" hidden>
                    <input type=\"number\" value=\"".$square_earth_max."\" id=\"amount-square_earth_max\" readonly name=\"square_earth_max\" hidden>";

            $sr["slider-range-distance_values"] = "values: [ ".$distance_min.", ".$distance_max." ],";
            $sr["distance"] = "<input type=\"number\" value=\"".$distance_min."\" id=\"amount-distance_min\" readonly name=\"distance_min\" hidden>
                    <input type=\"number\" value=\"".$distance_max."\" id=\"amount-distance_max\" readonly name=\"distance_max\" hidden>";


            $sr["type_house_2"] = "<label><input type=\"checkbox\" ".$type_house_3[0]." value=\"Кирпич\" name=\"typeHouse_2-1\" id=\"typeHouse_2-1\">Кирпич</label>
                        <label><input id=\"typeHouse_2-2\" ".$type_house_3[1]." value=\"Брус\" type=\"checkbox\" name=\"typeHouse_2-2\">Брус</label>
                        <label><input type=\"checkbox\" ".$type_house_3[2]." value=\"Бревно\" name=\"typeHouse_2-3\" id=\"typeHouse_2-3\">Бревно</label>
                        <label><input type=\"checkbox\" ".$type_house_3[3]." value=\"Металл\" name=\"typeHouse_2-4\" id=\"typeHouse_2-4\">Металл</label>
                        <label><input type=\"checkbox\" ".$type_house_3[4]." value=\"Пеноблоки\" name=\"typeHouse_2-5\" id=\"typeHouse_2-5\">Пеноблоки</label>
                        <label><input type=\"checkbox\" ".$type_house_3[5]." value=\"Сэндвич-панели\" name=\"typeHouse_2-6\" id=\"typeHouse_2-6\">Сэндвич-панели</label>
                        <label><input type=\"checkbox\" ".$type_house_3[6]." value=\"Ж/б Панели\" name=\"typeHouse_2-7\" id=\"typeHouse_2-7\">Ж/б Панели</label>
                        <label><input type=\"checkbox\" ".$type_house_3[7]." value=\"Экспериментальные материалы\" name=\"typeHouse_2-8\" id=\"typeHouse_2-8\">Экспериментальные материалы</label>";
            $sr["form_obj_2"] = "<label><input type=\"checkbox\" ".$type_house_2[0]." value=\"Дом\" name=\"typeObj_2-1\" id=\"typeObj_2-1\">Дом</label>
                        <label><input id=\"typeObj_2-2\" ".$type_house_2[1]." value=\"Дача\" type=\"checkbox\" name=\"typeObj_2-2\">Дача</label>
                        <label><input type=\"checkbox\" ".$type_house_2[2]." value=\"Коттедж\" name=\"typeObj_2-3\" id=\"typeObj_2-3\">Коттедж</label>
                        <label><input type=\"checkbox\" ".$type_house_2[3]." value=\"Таунхаус\" name=\"typeObj_2-4\" id=\"typeObj_2-4\">Таунхаус</label>";
            $sr["rooms"] = "<label for=\"checkbox-1\">Студия</label>
                            <input value=\"Студия\" ".$rooms[0]." type=\"checkbox\" name=\"checkbox-1\" id=\"checkbox-1\">
                            <label for=\"checkbox-2\">1</label>
                            <input value=\"1\" ".$rooms[1]."  type=\"checkbox\" name=\"checkbox-2\" id=\"checkbox-2\">
                            <label for=\"checkbox-3\">2</label>
                            <input value=\"2\" ".$rooms[2]." type=\"checkbox\" name=\"checkbox-3\" id=\"checkbox-3\">
                            <label for=\"checkbox-4\">3</label>
                            <input value=\"3\" ".$rooms[3]." type=\"checkbox\" name=\"checkbox-4\" id=\"checkbox-4\">
                            <label for=\"checkbox-5\">4</label>
                            <input value=\"4\" ".$rooms[4]." type=\"checkbox\" name=\"checkbox-5\" id=\"checkbox-5\">
                            <label for=\"checkbox-6\">5</label>
                            <input value=\"5\" ".$rooms[5]." type=\"checkbox\" name=\"checkbox-6\" id=\"checkbox-6\">
                            <label for=\"checkbox-7\">6</label>
                            <input value=\"6\" ".$rooms[6]." type=\"checkbox\" name=\"checkbox-7\" id=\"checkbox-7\">
                            <label for=\"checkbox-8\">7</label>
                            <input value=\"7\" ".$rooms[7]." type=\"checkbox\" name=\"checkbox-8\" id=\"checkbox-8\">
                            <label for=\"checkbox-9\">8</label>
                            <input value=\"8\" ".$rooms[8]." type=\"checkbox\" name=\"checkbox-9\" id=\"checkbox-9\">
                            <label for=\"checkbox-10\">9</label>
                            <input value=\"9\" ".$rooms[9]." type=\"checkbox\" name=\"checkbox-10\" id=\"checkbox-10\">
                            <label for=\"checkbox-11\">>9</label>
                            <input value=\"9+\" ".$rooms[10]." type=\"checkbox\" name=\"checkbox-11\" id=\"checkbox-11\">";
            $sr["type_house_1"] = "<label><input type=\"checkbox\" ".$type_house_1[0]." value=\"Кирпичный\" name=\"typeHouse_1-1\" id=\"typeHouse_1-1\">Кирпичный</label>
                        <label><input id=\"typeHouse_1-2\" ".$type_house_1[1]." value=\"Панельный\" type=\"checkbox\" name=\"typeHouse_1-2\">Панельный</label>
                        <label><input type=\"checkbox\"".$type_house_1[2]." value=\"Блочный\" name=\"typeHouse_1-3\" id=\"typeHouse_1-3\">Блочный</label>
                        <label><input type=\"checkbox\"".$type_house_1[3]." value=\"Монолитный\" name=\"typeHouse_1-4\" id=\"typeHouse_1-4\">Монолитный</label>
                        <label><input type=\"checkbox\" ".$type_house_1[4]." value=\"Деревянный\" name=\"typeHouse_1-5\" id=\"typeHouse_1-5\">Деревянный</label>";
            $sr["area_1"] = "<label><input type=\"checkbox\" value=\"Кировский\" ".$area_1[1]." id=\"area_1-1\">Кировский</label>
                        <label><input id=\"area_1-2\" value=\"Ворошиловский\" type=\"checkbox\" ".$area_1[2].">Ворошиловский</label>
                        <label><input type=\"checkbox\" value=\"Центральный\" ".$area_1[3]." id=\"area_1-3\">Центральный</label>
                        <label><input type=\"checkbox\" value=\"Дзержинский\" ".$area_1[4]." id=\"area_1-4\">Дзержинский</label>
                        <label><input type=\"checkbox\" value=\"Красноармейский\" ".$area_1[5]." id=\"area_1-5\">Красноармейский</label>
                        <label><input type=\"checkbox\" value=\"Краснооктябрьский\" ".$area_1[6]." id=\"area_1-6\">Краснооктябрьский</label>
                        <label><input type=\"checkbox\" value=\"Советский\" ".$area_1[7]." id=\"area_1-7\">Советский</label>
                        <label><input type=\"checkbox\" value=\"Тракторозаводский\" ".$area_1[8]." id=\"area_1-8\">Тракторозаводский</label>";
            $sr["area_2"] = "<label><input type=\"checkbox\" value=\"Квартал 1\" ".$area_2[1]." id=\"area_2-1\">Квартал 1</label>
                        <label><input type=\"checkbox\" value=\"Квартал 1а\" ".$area_2[2]." id=\"area_2-2\">Квартал 1а</label>
                        <label><input type=\"checkbox\" value=\"Квартал 2\" ".$area_2[3]." id=\"area_2-3\">Квартал 2</label>
                        <label><input type=\"checkbox\" value=\"Квартал 2а\" ".$area_2[4]." id=\"area_2-4\">Квартал 2а</label>
                        <label><input type=\"checkbox\" value=\"Квартал 3\" ".$area_2[5]." id=\"area_2-5\">Квартал 3</label>
                        <label><input type=\"checkbox\" value=\"Квартал 4\" ".$area_2[6]." id=\"area_2-6\">Квартал 4</label>
                        <label><input type=\"checkbox\" value=\"Квартал 5\" ".$area_2[7]." id=\"area_2-7\">Квартал 5</label>
                        <label><input type=\"checkbox\" value=\"Квартал 6\" ".$area_2[8]." id=\"area_2-8\">Квартал 6</label>
                        <label><input type=\"checkbox\" value=\"Квартал 7\" ".$area_2[9]." id=\"area_2-9\">Квартал 7</label>
                        <label><input type=\"checkbox\" value=\"Квартал 8\" ".$area_2[10]." id=\"area_2-10\">Квартал 8</label>
                        <label><input type=\"checkbox\" value=\"Квартал 9\" ".$area_2[11]." id=\"area_2-11\">Квартал 9</label>
                        <label><input type=\"checkbox\" value=\"Квартал 10\" ".$area_2[12]." id=\"area_2-12\">Квартал 10</label>
                        <label><input type=\"checkbox\" value=\"Квартал 11\" ".$area_2[13]." id=\"area_2-13\">Квартал 11</label>
                        <label><input type=\"checkbox\" value=\"Квартал 12\" ".$area_2[14]." id=\"area_2-14\">Квартал 12</label>
                        <label><input type=\"checkbox\" value=\"Квартал 13\" ".$area_2[15]." id=\"area_2-15\">Квартал 13</label>
                        <label><input type=\"checkbox\" value=\"Квартал 14\" ".$area_2[16]." id=\"area_2-16\">Квартал 14</label>
                        <label><input type=\"checkbox\" value=\"Квартал 15\" ".$area_2[17]." id=\"area_2-17\">Квартал 15</label>
                        <label><input type=\"checkbox\" value=\"Квартал 16\" ".$area_2[18]." id=\"area_2-18\">Квартал 16</label>
                        <label><input type=\"checkbox\" value=\"Квартал 17\" ".$area_2[19]." id=\"area_2-19\">Квартал 17</label>
                        <label><input type=\"checkbox\" value=\"Квартал 18\" ".$area_2[20]." id=\"area_2-20\">Квартал 18</label>
                        <label><input type=\"checkbox\" value=\"Квартал 19\" ".$area_2[21]." id=\"area_2-21\">Квартал 19</label>
                        <label><input type=\"checkbox\" value=\"Квартал 20\" ".$area_2[22]." id=\"area_2-22\">Квартал 20</label>
                        <label><input type=\"checkbox\" value=\"Квартал 21\" ".$area_2[23]." id=\"area_2-23\">Квартал 21</label>
                        <label><input type=\"checkbox\" value=\"Квартал 22\" ".$area_2[24]." id=\"area_2-24\">Квартал 22</label>
                        <label><input type=\"checkbox\" value=\"Квартал 23\" ".$area_2[25]." id=\"area_2-25\">Квартал 23</label>
                        <label><input type=\"checkbox\" value=\"Квартал 24\" ".$area_2[26]." id=\"area_2-26\">Квартал 24</label>
                        <label><input type=\"checkbox\" value=\"Квартал 25\" ".$area_2[27]." id=\"area_2-27\">Квартал 25</label>
                        <label><input type=\"checkbox\" value=\"Квартал 26\" ".$area_2[28]." id=\"area_2-28\">Квартал 26</label>
                        <label><input type=\"checkbox\" value=\"Квартал 27\" ".$area_2[29]." id=\"area_2-29\">Квартал 27</label>
                        <label><input type=\"checkbox\" value=\"Квартал 28\" ".$area_2[30]." id=\"area_2-30\">Квартал 28</label>
                        <label><input type=\"checkbox\" value=\"Квартал 29\" ".$area_2[31]." id=\"area_2-31\">Квартал 29</label>
                        <label><input type=\"checkbox\" value=\"Квартал 30\" ".$area_2[32]." id=\"area_2-32\">Квартал 30</label>
                        <label><input type=\"checkbox\" value=\"Квартал 31\" ".$area_2[33]." id=\"area_2-33\">Квартал 31</label>
                        <label><input type=\"checkbox\" value=\"Квартал 32\" ".$area_2[34]." id=\"area_2-34\">Квартал 32</label>
                        <label><input type=\"checkbox\" value=\"Квартал 33\" ".$area_2[35]." id=\"area_2-35\">Квартал 33</label>
                        <label><input type=\"checkbox\" value=\"Квартал 34\" ".$area_2[36]." id=\"area_2-36\">Квартал 34</label>
                        <label><input type=\"checkbox\" value=\"Квартал 35\" ".$area_2[37]." id=\"area_2-37\">Квартал 35</label>
                        <label><input type=\"checkbox\" value=\"Квартал 36\" ".$area_2[38]." id=\"area_2-38\">Квартал 36</label>
                        <label><input type=\"checkbox\" value=\"Квартал 37\" ".$area_2[39]." id=\"area_2-39\">Квартал 37</label>
                        <label><input type=\"checkbox\" value=\"Квартал 38\" ".$area_2[40]." id=\"area_2-40\">Квартал 38</label>
                        <label><input type=\"checkbox\" value=\"Квартал 39\" ".$area_2[41]." id=\"area_2-41\">Квартал 39</label>
                        <label><input type=\"checkbox\" value=\"Квартал 40\" ".$area_2[42]." id=\"area_2-42\">Квартал 40</label>
                        <label><input type=\"checkbox\" value=\"Квартал 41\" ".$area_2[43]." id=\"area_2-43\">Квартал 41</label>
                        <label><input type=\"checkbox\" value=\"Квартал 42\" ".$area_2[44]." id=\"area_2-44\">Квартал 42</label>
                        <label><input type=\"checkbox\" value=\"Квартал 100\" ".$area_2[45]." id=\"area_2-45\">Квартал 100</label>
                        <label><input type=\"checkbox\" value=\"Квартал 101\" ".$area_2[46]." id=\"area_2-46\">Квартал 101</label>
                        <label><input type=\"checkbox\" value=\"Квартал 102\" ".$area_2[47]." id=\"area_2-47\">Квартал 102</label>
                        <label><input type=\"checkbox\" value=\"Квартал А\" ".$area_2[48]." id=\"area_2-48\">Квартал А</label>
                        <label><input type=\"checkbox\" value=\"Квартал Б\" ".$area_2[49]." id=\"area_2-49\">Квартал Б</label>
                        <label><input type=\"checkbox\" value=\"Квартал В\" ".$area_2[50]." id=\"area_2-50\">Квартал В</label>
                        <label><input type=\"checkbox\" value=\"Квартал Г\" ".$area_2[51]." id=\"area_2-51\">Квартал Г</label>
                        <label><input type=\"checkbox\" value=\"Квартал Д\" ".$area_2[52]." id=\"area_2-52\">Квартал Д</label>
                        <label><input type=\"checkbox\" value=\"Квартал Е\" ".$area_2[53]." id=\"area_2-53\">Квартал Е</label>
                        <label><input type=\"checkbox\" value=\"1 микрорайон\" ".$area_2[54]." id=\"area_2-54\">1 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"2 микрорайон\" ".$area_2[55]." id=\"area_2-55\">2 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"3 микрорайон\" ".$area_2[56]." id=\"area_2-56\">3 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"4 микрорайон\" ".$area_2[57]." id=\"area_2-57\">4 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"5 микрорайон\" ".$area_2[58]." id=\"area_2-58\">5 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"6 микрорайон\" ".$area_2[59]." id=\"area_2-59\">6 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"7 микрорайон\" ".$area_2[60]." id=\"area_2-60\">7 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"8 микрорайон\" ".$area_2[61]." id=\"area_2-61\">8 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"9 микрорайон\" ".$area_2[62]." id=\"area_2-62\">9 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"10 микрорайон\" ".$area_2[63]." id=\"area_2-63\">10 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"10/16 микрорайон\" ".$area_2[64]." id=\"area_2-64\">10/16 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"11 микрорайон\" ".$area_2[65]." id=\"area_2-65\">11 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"12 микрорайон\" ".$area_2[66]." id=\"area_2-66\">12 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"13 микрорайон\" ".$area_2[67]." id=\"area_2-67\">13 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"14 микрорайон\" ".$area_2[68]." id=\"area_2-68\">14 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"15 микрорайон\" ".$area_2[69]." id=\"area_2-69\">15 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"16 микрорайон\" ".$area_2[70]." id=\"area_2-70\">16 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"17 микрорайон\" ".$area_2[71]." id=\"area_2-71\">17 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"18 микрорайон\" ".$area_2[72]." id=\"area_2-72\">18 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"19 микрорайон\" ".$area_2[73]." id=\"area_2-73\">19 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"20 микрорайон\" ".$area_2[74]." id=\"area_2-74\">20 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"21 микрорайон\" ".$area_2[75]." id=\"area_2-75\">21 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"22 микрорайон\" ".$area_2[76]." id=\"area_2-76\">22 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"23 микрорайон\" ".$area_2[77]." id=\"area_2-77\">23 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"24 микрорайон\" ".$area_2[78]." id=\"area_2-78\">24 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"25 микрорайон\" ".$area_2[79]." id=\"area_2-79\">25 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"26 микрорайон\" ".$area_2[80]." id=\"area_2-80\">26 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"27 микрорайон\" ".$area_2[81]." id=\"area_2-81\">27 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"28 микрорайон\" ".$area_2[82]." id=\"area_2-82\">28 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"29 микрорайон\" ".$area_2[83]." id=\"area_2-83\">29 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"30 микрорайон\" ".$area_2[84]." id=\"area_2-84\">30 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"31 микрорайон\" ".$area_2[85]." id=\"area_2-85\">31 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"32 микрорайон\" ".$area_2[86]." id=\"area_2-86\">32 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"33 микрорайон\" ".$area_2[87]." id=\"area_2-87\">33 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"34 микрорайон\" ".$area_2[88]." id=\"area_2-88\">34 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"35 микрорайон\" ".$area_2[89]." id=\"area_2-89\">35 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"36 микрорайон\" ".$area_2[90]." id=\"area_2-90\">36 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"37 микрорайон\" ".$area_2[91]." id=\"area_2-91\">37 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"38 микрорайон\" ".$area_2[92]." id=\"area_2-92\">38 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"Металлург\" ".$area_2[93]." id=\"area_2-93\">Металлург</label>
                        <label><input type=\"checkbox\" value=\"Металлург-1\" ".$area_2[94]." id=\"area_2-94\">Металлург-1</label>
                        <label><input type=\"checkbox\" value=\"Металлург-2\" ".$area_2[95]." id=\"area_2-95\">Металлург-2</label>
                        <label><input type=\"checkbox\" value=\"ЛПК\" ".$area_2[96]." id=\"area_2-96\">ЛПК</label>
                        <label><input type=\"checkbox\" value=\"Второй поселок\" ".$area_2[97]." id=\"area_2-97\">Второй поселок</label>
                        <label><input type=\"checkbox\" value=\"Станция трубная\" ".$area_2[98]." id=\"area_2-98\">Станция трубная</label>
                        <label><input type=\"checkbox\" value=\"Паромный\" ".$area_2[99]." id=\"area_2-99\">Паромный</label>
                        <label><input type=\"checkbox\" value=\"Тещино\" ".$area_2[100]." id=\"area_2-100\">Тещино</label>
                        <label><input type=\"checkbox\" value=\"Погромное\" ".$area_2[101]." id=\"area_2-101\">Погромное</label>
                        <label><input type=\"checkbox\" value=\"Зеленый\" ".$area_2[102]." id=\"area_2-102\">Зеленый</label>
                        <label><input type=\"checkbox\" value=\"Уральский\" ".$area_2[103]." id=\"area_2-103\">Уральский</label>
                        <label><input type=\"checkbox\" value=\"Краснооктябрьский\" ".$area_2[104]." id=\"area_2-104\">Краснооктябрьский</label>
                        <label><input type=\"checkbox\" value=\"Рабочий\" ".$area_2[105]." id=\"area_2-105\">Рабочий</label>
                        <label><input type=\"checkbox\" value=\"Средняя Ахтуба\" ".$area_2[106]." id=\"area_2-106\">Средняя Ахтуба</label>
                        <label><input type=\"checkbox\" value=\"Южный\" ".$area_2[107]." id=\"area_2-107\">Южный</label>";
        } else {
            $sr["type"] = "<option value=\"1\">Квартира</option>
                        <option value=\"2\">Дом, дача, коттетж</option>
                        <option value=\"3\">Комната</option>";
            $sr["obj_address"] = "<input name=\"address\" id=\"adr\" type=\"text\" placeholder=\"Адрес\" />";
            $sr["city"] = "<option value=\"\">По всем городам</option>
                        <option value=\"Волгоград\">Волгоград</option>
                        <option selected value=\"Волжский\">Волжский</option>";
            $sr["area_1_title"] = "<input type=\"text\" id=\"amount-area_1\" readonly value=\"Район\" hidden>";
            $sr["area_2_title"] = "<input type=\"text\" id=\"amount-area_2\" readonly value=\"Район\">";
            $sr["type_house_1_title"] = "<input type=\"text\" id=\"amount-typeHouse_1\" readonly value=\"Тип дома\">";
            $sr["rooms_title"] = "<input type=\"text\" id=\"amount-rooms\" value=\"Количество комнат\" readonly >";
            $sr["area_1"] = "<label><input type=\"checkbox\" value=\"Кировский\" name=\"area_1-1\" id=\"area_1-1\">Кировский</label>
                        <label><input id=\"area_1-2\" value=\"Ворошиловский\" type=\"checkbox\" name=\"area_1-2\">Ворошиловский</label>
                        <label><input type=\"checkbox\" value=\"Центральный\" name=\"area_1-3\" id=\"area_1-3\">Центральный</label>
                        <label><input type=\"checkbox\" value=\"Дзержинский\" name=\"area_1-4\" id=\"area_1-4\">Дзержинский</label>
                        <label><input type=\"checkbox\" value=\"Красноармейский\" name=\"area_1-5\" id=\"area_1-5\">Красноармейский</label>
                        <label><input type=\"checkbox\" value=\"Краснооктябрьский\" name=\"area_1-6\" id=\"area_1-6\">Краснооктябрьский</label>
                        <label><input type=\"checkbox\" value=\"Советский\" name=\"area_1-7\" id=\"area_1-7\">Советский</label>
                        <label><input type=\"checkbox\" value=\"Тракторозаводский\" name=\"area_1-8\" id=\"area_1-8\">Тракторозаводский</label>";
            $sr["area_2"] = "<label><input type=\"checkbox\" value=\"Квартал 1\" name=\"area_2-1\" id=\"area_2-1\">Квартал 1</label>
                        <label><input type=\"checkbox\" value=\"Квартал 1а\" name=\"area_2-2\" id=\"area_2-2\">Квартал 1а</label>
                        <label><input type=\"checkbox\" value=\"Квартал 2\" name=\"area_2-3\" id=\"area_2-3\">Квартал 2</label>
                        <label><input type=\"checkbox\" value=\"Квартал 2а\" name=\"area_2-4\" id=\"area_2-4\">Квартал 2а</label>
                        <label><input type=\"checkbox\" value=\"Квартал 3\" name=\"area_2-5\" id=\"area_2-5\">Квартал 3</label>
                        <label><input type=\"checkbox\" value=\"Квартал 4\" name=\"area_2-6\" id=\"area_2-6\">Квартал 4</label>
                        <label><input type=\"checkbox\" value=\"Квартал 5\" name=\"area_2-7\" id=\"area_2-7\">Квартал 5</label>
                        <label><input type=\"checkbox\" value=\"Квартал 6\" name=\"area_2-8\" id=\"area_2-8\">Квартал 6</label>
                        <label><input type=\"checkbox\" value=\"Квартал 7\" name=\"area_2-9\" id=\"area_2-9\">Квартал 7</label>
                        <label><input type=\"checkbox\" value=\"Квартал 8\" name=\"area_2-10\" id=\"area_2-10\">Квартал 8</label>
                        <label><input type=\"checkbox\" value=\"Квартал 9\" name=\"area_2-11\" id=\"area_2-11\">Квартал 9</label>
                        <label><input type=\"checkbox\" value=\"Квартал 10\" name=\"area_2-12\" id=\"area_2-12\">Квартал 10</label>
                        <label><input type=\"checkbox\" value=\"Квартал 11\" name=\"area_2-13\" id=\"area_2-13\">Квартал 11</label>
                        <label><input type=\"checkbox\" value=\"Квартал 12\" name=\"area_2-14\" id=\"area_2-14\">Квартал 12</label>
                        <label><input type=\"checkbox\" value=\"Квартал 13\" name=\"area_2-15\" id=\"area_2-15\">Квартал 13</label>
                        <label><input type=\"checkbox\" value=\"Квартал 14\" name=\"area_2-16\" id=\"area_2-16\">Квартал 14</label>
                        <label><input type=\"checkbox\" value=\"Квартал 15\" name=\"area_2-17\" id=\"area_2-17\">Квартал 15</label>
                        <label><input type=\"checkbox\" value=\"Квартал 16\" name=\"area_2-18\" id=\"area_2-18\">Квартал 16</label>
                        <label><input type=\"checkbox\" value=\"Квартал 17\" name=\"area_2-19\" id=\"area_2-19\">Квартал 17</label>
                        <label><input type=\"checkbox\" value=\"Квартал 18\" name=\"area_2-20\" id=\"area_2-20\">Квартал 18</label>
                        <label><input type=\"checkbox\" value=\"Квартал 19\" name=\"area_2-21\" id=\"area_2-21\">Квартал 19</label>
                        <label><input type=\"checkbox\" value=\"Квартал 20\" name=\"area_2-22\" id=\"area_2-22\">Квартал 20</label>
                        <label><input type=\"checkbox\" value=\"Квартал 21\" name=\"area_2-23\" id=\"area_2-23\">Квартал 21</label>
                        <label><input type=\"checkbox\" value=\"Квартал 22\" name=\"area_2-24\" id=\"area_2-24\">Квартал 22</label>
                        <label><input type=\"checkbox\" value=\"Квартал 23\" name=\"area_2-25\" id=\"area_2-25\">Квартал 23</label>
                        <label><input type=\"checkbox\" value=\"Квартал 24\" name=\"area_2-26\" id=\"area_2-26\">Квартал 24</label>
                        <label><input type=\"checkbox\" value=\"Квартал 25\" name=\"area_2-27\" id=\"area_2-27\">Квартал 25</label>
                        <label><input type=\"checkbox\" value=\"Квартал 26\" name=\"area_2-28\" id=\"area_2-28\">Квартал 26</label>
                        <label><input type=\"checkbox\" value=\"Квартал 27\" name=\"area_2-29\" id=\"area_2-29\">Квартал 27</label>
                        <label><input type=\"checkbox\" value=\"Квартал 28\" name=\"area_2-30\" id=\"area_2-30\">Квартал 28</label>
                        <label><input type=\"checkbox\" value=\"Квартал 29\" name=\"area_2-31\" id=\"area_2-31\">Квартал 29</label>
                        <label><input type=\"checkbox\" value=\"Квартал 30\" name=\"area_2-32\" id=\"area_2-32\">Квартал 30</label>
                        <label><input type=\"checkbox\" value=\"Квартал 31\" name=\"area_2-33\" id=\"area_2-33\">Квартал 31</label>
                        <label><input type=\"checkbox\" value=\"Квартал 32\" name=\"area_2-34\" id=\"area_2-34\">Квартал 32</label>
                        <label><input type=\"checkbox\" value=\"Квартал 33\" name=\"area_2-35\" id=\"area_2-35\">Квартал 33</label>
                        <label><input type=\"checkbox\" value=\"Квартал 34\" name=\"area_2-36\" id=\"area_2-36\">Квартал 34</label>
                        <label><input type=\"checkbox\" value=\"Квартал 35\" name=\"area_2-37\" id=\"area_2-37\">Квартал 35</label>
                        <label><input type=\"checkbox\" value=\"Квартал 36\" name=\"area_2-38\" id=\"area_2-38\">Квартал 36</label>
                        <label><input type=\"checkbox\" value=\"Квартал 37\" name=\"area_2-39\" id=\"area_2-39\">Квартал 37</label>
                        <label><input type=\"checkbox\" value=\"Квартал 38\" name=\"area_2-40\" id=\"area_2-40\">Квартал 38</label>
                        <label><input type=\"checkbox\" value=\"Квартал 39\" name=\"area_2-41\" id=\"area_2-41\">Квартал 39</label>
                        <label><input type=\"checkbox\" value=\"Квартал 40\" name=\"area_2-42\" id=\"area_2-42\">Квартал 40</label>
                        <label><input type=\"checkbox\" value=\"Квартал 41\" name=\"area_2-43\" id=\"area_2-43\">Квартал 41</label>
                        <label><input type=\"checkbox\" value=\"Квартал 42\" name=\"area_2-44\" id=\"area_2-44\">Квартал 42</label>
                        <label><input type=\"checkbox\" value=\"Квартал 100\" name=\"area_2-45\" id=\"area_2-45\">Квартал 100</label>
                        <label><input type=\"checkbox\" value=\"Квартал 101\" name=\"area_2-46\" id=\"area_2-46\">Квартал 101</label>
                        <label><input type=\"checkbox\" value=\"Квартал 102\" name=\"area_2-47\" id=\"area_2-47\">Квартал 102</label>
                        <label><input type=\"checkbox\" value=\"Квартал А\" name=\"area_2-48\" id=\"area_2-48\">Квартал А</label>
                        <label><input type=\"checkbox\" value=\"Квартал Б\" name=\"area_2-49\" id=\"area_2-49\">Квартал Б</label>
                        <label><input type=\"checkbox\" value=\"Квартал В\" name=\"area_2-50\" id=\"area_2-50\">Квартал В</label>
                        <label><input type=\"checkbox\" value=\"Квартал Г\" name=\"area_2-51\" id=\"area_2-51\">Квартал Г</label>
                        <label><input type=\"checkbox\" value=\"Квартал Д\" name=\"area_2-52\" id=\"area_2-52\">Квартал Д</label>
                        <label><input type=\"checkbox\" value=\"Квартал Е\" name=\"area_2-53\" id=\"area_2-53\">Квартал Е</label>
                        <label><input type=\"checkbox\" value=\"1 микрорайон\" name=\"area_2-54\" id=\"area_2-54\">1 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"2 микрорайон\" name=\"area_2-55\" id=\"area_2-55\">2 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"3 микрорайон\" name=\"area_2-56\" id=\"area_2-56\">3 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"4 микрорайон\" name=\"area_2-57\" id=\"area_2-57\">4 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"5 микрорайон\" name=\"area_2-58\" id=\"area_2-58\">5 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"6 микрорайон\" name=\"area_2-59\" id=\"area_2-59\">6 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"7 микрорайон\" name=\"area_2-60\" id=\"area_2-60\">7 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"8 микрорайон\" name=\"area_2-61\" id=\"area_2-61\">8 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"9 микрорайон\" name=\"area_2-62\" id=\"area_2-62\">9 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"10 микрорайон\" name=\"area_2-63\" id=\"area_2-63\">10 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"10/16 микрорайон\" name=\"area_2-64\" id=\"area_2-64\">10/16 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"11 микрорайон\" name=\"area_2-65\" id=\"area_2-65\">11 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"12 микрорайон\" name=\"area_2-66\" id=\"area_2-66\">12 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"13 микрорайон\" name=\"area_2-67\" id=\"area_2-67\">13 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"14 микрорайон\" name=\"area_2-68\" id=\"area_2-68\">14 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"15 микрорайон\" name=\"area_2-69\" id=\"area_2-69\">15 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"16 микрорайон\" name=\"area_2-70\" id=\"area_2-70\">16 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"17 микрорайон\" name=\"area_2-71\" id=\"area_2-71\">17 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"18 микрорайон\" name=\"area_2-72\" id=\"area_2-72\">18 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"19 микрорайон\" name=\"area_2-73\" id=\"area_2-73\">19 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"20 микрорайон\" name=\"area_2-74\" id=\"area_2-74\">20 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"21 микрорайон\" name=\"area_2-75\" id=\"area_2-75\">21 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"22 микрорайон\" name=\"area_2-76\" id=\"area_2-76\">22 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"23 микрорайон\" name=\"area_2-77\" id=\"area_2-77\">23 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"24 микрорайон\" name=\"area_2-78\" id=\"area_2-78\">24 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"25 микрорайон\" name=\"area_2-79\" id=\"area_2-79\">25 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"26 микрорайон\" name=\"area_2-80\" id=\"area_2-80\">26 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"27 микрорайон\" name=\"area_2-81\" id=\"area_2-81\">27 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"28 микрорайон\" name=\"area_2-82\" id=\"area_2-82\">28 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"29 микрорайон\" name=\"area_2-83\" id=\"area_2-83\">29 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"30 микрорайон\" name=\"area_2-84\" id=\"area_2-84\">30 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"31 микрорайон\" name=\"area_2-85\" id=\"area_2-85\">31 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"32 микрорайон\" name=\"area_2-86\" id=\"area_2-86\">32 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"33 микрорайон\" name=\"area_2-87\" id=\"area_2-87\">33 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"34 микрорайон\" name=\"area_2-88\" id=\"area_2-88\">34 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"35 микрорайон\" name=\"area_2-89\" id=\"area_2-89\">35 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"36 микрорайон\" name=\"area_2-90\" id=\"area_2-90\">36 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"37 микрорайон\" name=\"area_2-91\" id=\"area_2-91\">37 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"38 микрорайон\" name=\"area_2-92\" id=\"area_2-92\">38 микрорайон</label>
                        <label><input type=\"checkbox\" value=\"Металлург\" name=\"area_2-93\" id=\"area_2-93\">Металлург</label>
                        <label><input type=\"checkbox\" value=\"Металлург-1\" name=\"area_2-94\" id=\"area_2-94\">Металлург-1</label>
                        <label><input type=\"checkbox\" value=\"Металлург-2\" name=\"area_2-95\" id=\"area_2-95\">Металлург-2</label>
                        <label><input type=\"checkbox\" value=\"ЛПК\" name=\"area_2-96\" id=\"area_2-96\">ЛПК</label>
                        <label><input type=\"checkbox\" value=\"Второй поселок\" name=\"area_2-97\" id=\"area_2-97\">Второй поселок</label>
                        <label><input type=\"checkbox\" value=\"Станция трубная\" name=\"area_2-98\" id=\"area_2-98\">Станция трубная</label>
                        <label><input type=\"checkbox\" value=\"Паромный\" name=\"area_2-99\" id=\"area_2-99\">Паромный</label>
                        <label><input type=\"checkbox\" value=\"Тещино\" name=\"area_2-100\" id=\"area_2-100\">Тещино</label>
                        <label><input type=\"checkbox\" value=\"Погромное\" name=\"area_2-101\" id=\"area_2-101\">Погромное</label>
                        <label><input type=\"checkbox\" value=\"Зеленый\" name=\"area_2-102\" id=\"area_2-102\">Зеленый</label>
                        <label><input type=\"checkbox\" value=\"Уральский\" name=\"area_2-103\" id=\"area_2-103\">Уральский</label>
                        <label><input type=\"checkbox\" value=\"Краснооктябрьский\" name=\"area_2-104\" id=\"area_2-104\">Краснооктябрьский</label>
                        <label><input type=\"checkbox\" value=\"Рабочий\" name=\"area_2-105\" id=\"area_2-105\">Рабочий</label>
                        <label><input type=\"checkbox\" value=\"Средняя Ахтуба\" name=\"area_2-106\" id=\"area_2-106\">Средняя Ахтуба</label>
                        <label><input type=\"checkbox\" value=\"Южный\" name=\"area_2-107\" id=\"area_2-107\">Южный</label>";
            $sr["typedeal"] = "<option value=\"\">Тип сделки</option>
                        <option value=\"Продажа\">Продажа</option>
                        <option value=\"Обмен\">Обмен</option>";
            $sr["rooms"] = "<label for=\"checkbox-1\">Студия</label>
                            <input value=\"Студия\" type=\"checkbox\" name=\"checkbox-1\" id=\"checkbox-1\">
                            <label for=\"checkbox-2\">1</label>
                            <input value=\"1\"  type=\"checkbox\" name=\"checkbox-2\" id=\"checkbox-2\">
                            <label for=\"checkbox-3\">2</label>
                            <input value=\"2\" type=\"checkbox\" name=\"checkbox-3\" id=\"checkbox-3\">
                            <label for=\"checkbox-4\">3</label>
                            <input value=\"3\" type=\"checkbox\" name=\"checkbox-4\" id=\"checkbox-4\">
                            <label for=\"checkbox-5\">4</label>
                            <input value=\"4\" type=\"checkbox\" name=\"checkbox-5\" id=\"checkbox-5\">
                            <label for=\"checkbox-6\">5</label>
                            <input value=\"5\" type=\"checkbox\" name=\"checkbox-6\" id=\"checkbox-6\">
                            <label for=\"checkbox-7\">6</label>
                            <input value=\"6\" type=\"checkbox\" name=\"checkbox-7\" id=\"checkbox-7\">
                            <label for=\"checkbox-8\">7</label>
                            <input value=\"7\" type=\"checkbox\" name=\"checkbox-8\" id=\"checkbox-8\">
                            <label for=\"checkbox-9\">8</label>
                            <input value=\"8\" type=\"checkbox\" name=\"checkbox-9\" id=\"checkbox-9\">
                            <label for=\"checkbox-10\">9</label>
                            <input value=\"9\" type=\"checkbox\" name=\"checkbox-10\" id=\"checkbox-10\">
                            <label for=\"checkbox-11\">>9</label>
                            <input value=\"9+\" type=\"checkbox\" name=\"checkbox-11\" id=\"checkbox-11\">";
            $sr["form_obj_3"] = "<option value=\"\">Тип объекта</option>
                        <option value=\"Гостиничного\">Гостиничного</option>
                            <option value=\"Коридорного\">Коридорного</option>
                            <option value=\"Секционного\">Секционного</option>
                            <option value=\"Коммунальная\">Коммунальная</option>";
            $sr["type_house_2_title"] = "<input type=\"text\" id=\"amount-formObj_2\" readonly value=\"Вид обьекта\" hidden>";
            $sr["type_house_3_title"] = "<input type=\"text\" id=\"amount-typeHouse_2\" readonly value=\"Материал стен\" hidden>";
            $sr["form_obj_2"] = "<label><input type=\"checkbox\" value=\"Дом\" name=\"typeObj_2-1\" id=\"typeObj_2-1\">Дом</label>
                        <label><input id=\"typeObj_2-2\" value=\"Дача\" type=\"checkbox\" name=\"typeObj_2-2\">Дача</label>
                        <label><input type=\"checkbox\" value=\"Коттедж\" name=\"typeObj_2-3\" id=\"typeObj_2-3\">Коттедж</label>
                        <label><input type=\"checkbox\" value=\"Таунхаус\" name=\"typeObj_2-4\" id=\"typeObj_2-4\">Таунхаус</label>";
            $sr["form_obj_1"] = "<option value=\"\">Тип объекта</option>
                        <option value=\"Вторичка\">Вторичка</option>
                        <option value=\"Новостройка\">Новостройка</option>";
            $sr["price"] = "<input value=\"\" name=\"price_min\" id=\"min-price\" type=\"number\" placeholder=\"от\"><span style=\"float: left;\">-</span>
                        <input value=\"\" name=\"price_max\" id=\"max-price\" type=\"number\" placeholder=\"до\">";
            $sr["slider-range-square_1_values"] = "values: [ 10, 200 ],";
            $sr["amount-square"] = "<input type=\"number\" id=\"amount-square_min\" readonly name=\"square_1_min\" hidden>
                    <input type=\"number\" id=\"amount-square_max\" readonly name=\"square_1_max\" hidden>";
            
            $sr["slider-range-floor_values"] = "values: [ 1, 31 ],";
            $sr["amount-floor"] = "<input type=\"number\" id=\"amount-floor_min\" readonly name=\"floor_min\" hidden>
                    <input type=\"number\" id=\"amount-floor_max\" readonly name=\"floor_max\" hidden>";

            $sr["slider-range-floorInObj_1_values"] = "values: [ 1, 31 ],";
            $sr["floorInObj_1"] = "<input type=\"number\" id=\"amount-floorInObj_1_min\"  readonly name=\"floorInObj_1_min\" hidden>
                    <input type=\"number\" id=\"amount-floorInObj_1_max\" readonly name=\"floorInObj_1_max\" hidden>";

            $sr["slider-range-floorInObj_2_values"] = "values: [ 1, 5 ],";
            $sr["floorInObj_2"] = "<input type=\"number\"  id=\"amount-floorInObj_2_min\" readonly name=\"floorInObj_2_min\" hidden>
                    <input type=\"number\" id=\"amount-floorInObj_2_max\" readonly name=\"floorInObj_2_max\" hidden>";

            $sr["slider-range-square_2_values"] = "values: [ 10, 500 ],";
            $sr["square_2"] = "<input type=\"number\" id=\"amount-square_2_min\" readonly name=\"square_2_min\" hidden>
                    <input type=\"number\"  id=\"amount-square_2_max\" readonly name=\"square_2_max\" hidden>";

            $sr["slider-range-square_earth_values"] = "values: [ 1, 100 ],";
            $sr["square_earth"] = "<input type=\"number\" id=\"amount-square_earth_min\" readonly name=\"square_earth_min\" hidden>
                    <input type=\"number\" id=\"amount-square_earth_max\" readonly name=\"square_earth_max\" hidden>";

            $sr["slider-range-distance_values"] = "values: [ 0, 100 ],";
            $sr["distance"] = "<input type=\"number\" id=\"amount-distance_min\" readonly name=\"distance_min\" hidden>
                    <input type=\"number\" id=\"amount-distance_max\" readonly name=\"distance_max\" hidden>";
            
            $sr["type_house_2"] = "<label><input type=\"checkbox\" value=\"Кирпич\" name=\"typeHouse_2-1\" id=\"typeHouse_2-1\">Кирпич</label>
                        <label><input id=\"typeHouse_2-2\" value=\"Брус\" type=\"checkbox\" name=\"typeHouse_2-2\">Брус</label>
                        <label><input type=\"checkbox\" value=\"Бревно\" name=\"typeHouse_2-3\" id=\"typeHouse_2-3\">Бревно</label>
                        <label><input type=\"checkbox\" value=\"Металл\" name=\"typeHouse_2-4\" id=\"typeHouse_2-4\">Металл</label>
                        <label><input type=\"checkbox\" value=\"Пеноблоки\" name=\"typeHouse_2-5\" id=\"typeHouse_2-5\">Пеноблоки</label>
                        <label><input type=\"checkbox\" value=\"Сэндвич-панели\" name=\"typeHouse_2-6\" id=\"typeHouse_2-6\">Сэндвич-панели</label>
                        <label><input type=\"checkbox\" value=\"Ж/б Панели\" name=\"typeHouse_2-7\" id=\"typeHouse_2-7\">Ж/б Панели</label>
                        <label><input type=\"checkbox\" value=\"Экспериментальные материалы\" name=\"typeHouse_2-8\" id=\"typeHouse_2-8\">Экспериментальные материалы</label>";
            $sr["type_house_1"] = "<label><input type=\"checkbox\" value=\"Кирпичный\" name=\"typeHouse_1-1\" id=\"typeHouse_1-1\">Кирпичный</label>
                        <label><input id=\"typeHouse_1-2\" value=\"Панельный\" type=\"checkbox\" name=\"typeHouse_1-2\">Панельный</label>
                        <label><input type=\"checkbox\" value=\"Блочный\" name=\"typeHouse_1-3\" id=\"typeHouse_1-3\">Блочный</label>
                        <label><input type=\"checkbox\" value=\"Монолитный\" name=\"typeHouse_1-4\" id=\"typeHouse_1-4\">Монолитный</label>
                        <label><input type=\"checkbox\" value=\"Деревянный\" name=\"typeHouse_1-5\" id=\"typeHouse_1-5\">Деревянный</label>";
            $sr["script"] = " ";
            $rieltors = "";
            if ($this->data["typepage"] == "all" || $this->data["typepage"] == ""){
                $rieltors .= "<select id=\"rieltors\" name=\"rieltor\"><option value=\"\">Риелтор</option>";
                for($i = 0; $i < count($this->users); $i++) {
                    $rieltors .= "<option value=\"".$this->users[$i]["id"]."\">".$this->users[$i]["name"]."</option>";
                }
                $rieltors .= "</select>";
            }

            $sr["rieltors"] = $rieltors;
        }
        $sr["typepage"] = (isset($this->data["typepage"]))? $this->data["typepage"]: "all";
       return $this->getReplaceTemplate($sr, "filter");
    }

    private function getSearchFilterArea_1(){
        $area_1 = array();
        for ($i = 1; $i < 9; $i++) {
            $area_1[$i] = "name =\"area_1-".$i."\"";
        }
        return $area_1;
    }
    private function getSearchFilterArea_2(){
        $area_2 = array();
        for ($i = 1; $i < 108; $i++) {
            $area_2[$i] = "name =\"area_2-".$i."\"";
        }
        return $area_2;
    }

    private function search() {
        $type = $this->data["type"];
        switch ($type) {
            case "1": $square_min = ($this->data["square_1_min"] == 10)? 1: $this->data["square_1_min"];
                $deal = $this->data["typedeal"];
                $square_max = ($this->data["square_1_max"] == 200)? 99999999: $this->data["square_1_max"];
                $city = $this->data["city"];
                $area = $this->getAreaSearch();
                $room = $this->getRoom();
                $address = $this->data["address"];
                $form = $this->data["formObj_1"];
                $floor_min = ($this->data["floor_min"] == 1)? 1: $this->data["floor_min"];
                $floor_max = ($this->data["floor_max"] == 31)? 99999: $this->data["floor_max"];
                $floorInObj_min = ($this->data["floorInObj_1_min"] == 1)? 1: $this->data["floorInObj_1_min"];
                $floorInObj_max = ($this->data["floorInObj_1_max"] == 31)? 999: $this->data["floorInObj_1_max"];
                $typeHouse = $this->getTypeHouse_1();
                $price_min = ($this->data["price_min"]== 0)? 1: $this->data["price_min"];
                $price_max = ($this->data["price_max"]== 0)? 999999999: $this->data["price_max"];
                switch ($this->data["typepage"]) {
                    case "my": $field = "created_id";
                        $value = $this->user_info["id"];
                        break;
                    case "in_work": $field = "working_id";
                        $value = $this->user_info["id"];
                        break;
                    case "pre_working": $field = "pre_working";
                        $value = 1;
                        break;
                    case "completed": $field = "completed_id";
                        $value = $this->user_info["id"];
                        break;
                    case "deleted": $field = "deleted";
                        $value = 1;
                        break;
                    default: $field = "created_id";
                        $value = $this->data["rieltor"];
                        break;
                }
                $fieldsAndValues = array($field => array("=", $value),"obj_address" => array("LIKE", $address),"deleted_id" => array("=", "0"),"obj_category" => array("=", $type),"obj_city" => array("=", $city),"obj_area" => $area, "obj_square" => array(">", $square_min, $square_max), "obj_rooms" => $room, "obj_type" => array("=", $form), "obj_floor" => array(">", $floor_min, $floor_max), "obj_home_floors" => array(">", $floorInObj_min, $floorInObj_max), "obj_build_type" => $typeHouse, "obj_price" => array(">", $price_min, $price_max), "obj_deal" => array("=", $deal));
                $result = $this->object->searchObj($fieldsAndValues);
                if ($result) {
                    $_SESSION["message"] = "SUCCESS_SEARCH";
                    $_SESSION["type_message"] = "success";
                    $_SESSION["search_count"] = count($result);
                    return $result;
                }
                break;
            case "2": $city = $this->data["city"];
                $area = $this->getAreaSearch();
                $deal = $this->data["typedeal"];
                $form = $this->getFormObj();
                $address = $this->data["address"];
                $square_min = ($this->data["square_2_min"] == 10)? 1: $this->data["square_2_min"];
                $square_max = ($this->data["square_2_max"] == 500)? 999999999: $this->data["square_2_max"];
                $square_earth_min = ($this->data["square_earth_min"] == 1)? 1: $this->data["square_earth_min"];
                $square_earth_max = ($this->data["square_earth_max"] == 100)? 9999: $this->data["square_earth_max"];
                $floorInObj_min = ($this->data["floorInObj_2_min"] == 1)? 1: $this->data["floorInObj_2_min"];
                $floorInObj_max = ($this->data["floorInObj_2_max"] == 5)? 99999: $this->data["floorInObj_2_max"];
                $distance_min = ($this->data["distance_min"] == 0)? -1: $this->data["distance_min"];
                $distance_max = ($this->data["distance_max"] == 100)? 99999: $this->data["distance_max"];
                $price_min = ($this->data["price_min"]== 0)? 1: $this->data["price_min"];
                $price_max = ($this->data["price_max"]== 0)? 999999999: $this->data["price_max"];
                $typeHouse = $this->getTypeHouse_2();
                switch ($this->data["typepage"]) {
                    case "my": $field = "created_id";
                        $value = $this->user_info["id"];
                        break;
                    case "in_work": $field = "working_id";
                        $value = $this->user_info["id"];
                        break;
                    case "pre_working": $field = "pre_working";
                        $value = 1;
                        break;
                    case "completed": $field = "completed_id";
                        $value = $this->user_info["id"];
                        break;
                    case "deleted": $field = "deleted";
                        $value = 1;
                        break;
                    default: $field = "created_id";
                        $value = $this->data["rieltor"];
                        break;
                }
                $fieldsAndValues = array($field => array("=", $value),"deleted_id" => array("=", "0"),"obj_address" => array("LIKE", $address),"obj_category" => array("=", $type),"obj_city" => array("=", $city),"obj_area" => $area, "obj_house_square" => array(">", $square_min, $square_max), "obj_earth_square" => array(">", $square_earth_min, $square_earth_max), "obj_type" => $form, "obj_distance" => array(">", $distance_min, $distance_max), "obj_home_floors" => array(">", $floorInObj_min, $floorInObj_max), "obj_build_type" => $typeHouse, "obj_price" => array(">", $price_min, $price_max), "obj_deal" => array("=", $deal));
                $result = $this->object->searchObj($fieldsAndValues);
                if ($result) {
                    $_SESSION["message"] = "SUCCESS_SEARCH";
                    $_SESSION["type_message"] = "success";
                    $_SESSION["search_count"] = count($result);
                    return $result;
                }
                break;
            case "3":
                $square_min = ($this->data["square_1_min"] == 10)? 1: $this->data["square_1_min"];
                $deal = $this->data["typedeal"];
                $square_max = ($this->data["square_1_max"] == 200)? 99999999: $this->data["square_1_max"];
                $city = $this->data["city"];
                $address = $this->data["address"];
                $area = $this->getAreaSearch();
                $room = $this->getRoom();
                $form = $this->data["formObj_3"];
                $floor_min = ($this->data["floor_min"] == 1)? 1: $this->data["floor_min"];
                $floor_max = ($this->data["floor_max"] == 31)? 99999: $this->data["floor_max"];
                $floorInObj_min = ($this->data["floorInObj_1_min"] == 1)? 1: $this->data["floorInObj_1_min"];
                $floorInObj_max = ($this->data["floorInObj_1_max"] == 31)? 999: $this->data["floorInObj_1_max"];
                $typeHouse = $this->getTypeHouse_1();
                $price_min = ($this->data["price_min"]== 0)? 1: $this->data["price_min"];
                $price_max = ($this->data["price_max"]== 0)? 999999999: $this->data["price_max"];
                switch ($this->data["typepage"]) {
                    case "my": $field = "created_id";
                        $value = $this->user_info["id"];
                        break;
                    case "in_work": $field = "working_id";
                        $value = $this->user_info["id"];
                        break;
                    case "pre_working": $field = "pre_working";
                        $value = 1;
                        break;
                    case "completed": $field = "completed_id";
                        $value = $this->user_info["id"];
                        break;
                    case "deleted": $field = "deleted";
                        $value = 1;
                        break;
                    default: $field = "created_id";
                        $value = $this->data["rieltor"];
                        break;
                }
                $fieldsAndValues = array($field => array("=", $value),"deleted_id" => array("=", "0"),"obj_address" => array("LIKE", $address),"obj_category" => array("=", $type),"obj_city" => array("=", $city),"obj_area" => $area, "obj_square" => array(">", $square_min, $square_max), "obj_rooms" => $room, "obj_type" => array("=", $form), "obj_floor" => array(">", $floor_min, $floor_max), "obj_home_floors" => array(">", $floorInObj_min, $floorInObj_max), "obj_build_type" => $typeHouse, "obj_price" => array(">", $price_min, $price_max), "obj_deal" => array("=", $deal));
                $result = $this->object->searchObj($fieldsAndValues);
                if ($result) {
                    $_SESSION["message"] = "SUCCESS_SEARCH";
                    $_SESSION["type_message"] = "success";
                    $_SESSION["search_count"] = count($result);
                    return $result;
                }
                break;
            default: break;
        }

    }

    private function getTypeHouse_1() {
        $typeHouse = array();
        $countTypes = 1;
        $typeHouse[0] = "OR";
        for ($i = 1; $i < 6; $i++) {
            if (isset($this->data["typeHouse_1-".$i])) {
                $typeHouse["$countTypes"] = $this->data["typeHouse_1-".$i];
                // $area .= $this->data["area_1-".$i.","];
                $countTypes++;
            }
        }
        if($typeHouse[1] != "") {
            return $typeHouse;
        } else {
            return "";
        }
    }

    private function getTypeHouse_2() {
        $typeHouse = array();
        $countTypes = 1;
        $typeHouse[0] = "OR";
        for ($i = 1; $i < 9; $i++) {
            if (isset($this->data["typeHouse_2-".$i])) {
                $typeHouse["$countTypes"] = $this->data["typeHouse_2-".$i];
                // $area .= $this->data["area_1-".$i.","];
                $countTypes++;
            }
        }
        if($typeHouse[1] != "") {
            return $typeHouse;
        } else {
            return "";
        }
    }

    private function getFormObj() {
        $form = array();
        $countform = 1;
        $form[0] = "OR";
        for ($i = 1; $i < 5; $i++) {
            if (isset($this->data["typeObj_2-".$i])) {
                $form["$countform"] = $this->data["typeObj_2-".$i];
                // $area .= $this->data["area_1-".$i.","];
                $countform++;
            }
        }
        if($form[1] != "") {
            return $form;
        } else {
            return "";
        }
    }

    private function getRoom() {
        $room = array();
        $countRoom = 1;
        $room[0] = "OR";
        for ($i = 1; $i < 12; $i++) {
            if (isset($this->data["checkbox-".$i])) {
                $room["$countRoom"] = $this->data["checkbox-".$i];
                // $area .= $this->data["area_1-".$i.","];
                $countRoom++;
            }
        }

        if($room[1] != "") {
            return $room;
        } else {
            return "";
        }
    }

    private function getAreaSearch() {
        $area = array();
        $countArea = 1;
        if ($this->data["city"] != "") {
            $area[0] = "OR";
            if ($this->data["city"] == "Волгоград") {
                for ($i = 1; $i < 9; $i++) {
                    if (isset($this->data["area_1-".$i])) {
                        $area["$countArea"] .= $this->data["area_1-".$i];
                        // $area .= $this->data["area_1-".$i.","];
                        $countArea++;
                    }
                }
            } else {
                for ($i = 1; $i < 108; $i++) {
                    if (isset($this->data["area_2-".$i])) {
                        $area["$countArea"] = $this->data["area_2-".$i];
                        $countArea++;
                    }
                }
            }
        }
        if($area[1] != "") {
            return $area;
        } else {
            return "";
        }

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
                    <li class=\"active dropdown\">
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
        $text .= "</ul></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li class=\"dropdown\">
                        <a class=\"dropdown - toggle\" data-toggle=\"dropdown\" href=\"#\">Сообщения<span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\" >
                            <li ><a href = \"".$this->config->siteAddress."?view=messages\" >Просмотр сообщений</a ></li >";
            $text .= "<li><a href=\"" . $this->config->siteAddress . "?view=add_message\" >Добавить новое сообщение</a ></li >";
            $text .= "</ul></li>";
        } else {
            $text .= "<li>
                        <a href=\"".$this->config->siteAddress."?view=messages\">Сообщения</a>
                        </li >";
        }

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