<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 22:51
 */

require_once "modules_class.php";

class RegPageContent extends Modules
{

    protected function getTitle()
    {
        return "Регистрация на сайте";
    }

    protected function getDescription()
    {
        return "Регистрация пользователя на сайте";
    }

    protected function getKeywords()
    {
        return "Регистрация пользователя на сайте";
    }

    protected function getMenu()
    {
        // TODO: Implement getMenu() method.
    }

    protected function getMiddle()
    {        
        $sr["login"] = $_SESSION["login"];
        return $this->getReplaceTemplate($sr, "registration");
    }

    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
    }

    protected function getTop()
    {
        // TODO: Implement getTop() method.
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
                    <li class=\"dropdown active\">
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