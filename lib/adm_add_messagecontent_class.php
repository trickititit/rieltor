<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 21.07.2016
 * Time: 22:57
 */
require_once "modulescabinet_class.php";

class AdmAddMessageContent extends ModulesCabinet {

    private $adm_messages;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->adm_messages = $this->adm_message->get($this->data["id"]);
    }

    protected function getTitle()
    {
        return "Создание новое сообщение";
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
        return $this->getTemplateOnly("adm_add_message");
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
            $text .= "<li class=\"dropdown active\">
                        <a class=\"dropdown - toggle\" data-toggle=\"dropdown\" href=\"#\">Сообщения<span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\" >
                            <li ><a href = \"".$this->config->siteAddress."cabinet\?view=messages\" >Просмотр сообщений</a ></li >";
            $text .= "<li><a href=\"" . $this->config->siteAddress . "cabinet\?view=add_message\" >Добавить новое сообщение</a ></li >";
            $text .= "</ul></li>";
        } else {
            $text .= "<li class='active'>
                        <a href=\"".$this->config->siteAddress."cabinet\?view=messages\">Сообщения</a>
                        </li >";
        }

        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li>
                        <a href=\"".$this->config->siteAddress."cabinet\?view=comfort\">Удобства</a>
                    </li>";
        }
        $text .="<li>
                        <a href=\"".$this->config->siteAddress."cabinet\?view=favorites\">Избранное</a>
                    </li>
                </ul>";
        return $text;
    }
}