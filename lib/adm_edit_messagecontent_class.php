<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 21.07.2016
 * Time: 22:57
 */
require_once "modules_class.php";

class AdmEditMessageContent extends Modules {

    private $adm_messages;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->adm_messages = $this->adm_message->get($this->data["id"]);
    }

    protected function getTitle()
    {
        return "Редактировае сообщения";
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
        $sr["title"] = $this->adm_messages["title"];
        $sr["content"] = htmlspecialchars_decode($this->adm_messages["description"]);
        $sr["short_content"] = $this->adm_messages["short_desc"];
        $sr["type"] = $this->getType();
        $sr["id"] = $this->adm_messages["id"];
        return $this->getReplaceTemplate($sr, "adm_edit_message");
    }
    
    private function getType(){
        $g = array("normal", "attention", "ok", "warning");
        $type = array();
        for ($i = 0; $i < 4; $i++) {
            if ($this->adm_messages["type"] == $g[$i]) {
                $type[$i] = "value=\"$g[$i]\" selected";
            } else {
                $type[$i] = "value=\"".$g[$i]."\"";
            }
        }
        $text = "<option ".$type[0].">Обычное</option>
                                            <option ".$type[1].">Важное</option>
                                            <option  ".$type[2].">Успешное</option>
                                            <option  ".$type[3].">Внимание</option>";
        return $text;
    }


    private function formantDate($time) {
        return date("m-d H:i", $time);
    }

    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
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
            $text .= "<li class='active'>
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