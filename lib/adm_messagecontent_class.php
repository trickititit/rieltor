<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 21.07.2016
 * Time: 22:57
 */
require_once "modules_class.php";

class AdmMessageContent extends Modules {

    private $adm_messages;
    private $page;
    private $count_on_page;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->page = (isset($this->data["page"]))? $this->data["page"]: 1;
        $this->adm_messages = $this->adm_message->getAll();
        $this->count_on_page = 5;
    }

    protected function getTitle()
    {
        return "Сообщения";
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
        $sr["adm_messages"] = $this->getMessagesTable();
        return $this->getReplaceTemplate($sr, "adm_message");
    }

    private function getMessagesTable(){
        $start = ($this->page - 1) * $this->count_on_page;
        $end = (count($this->adm_messages) > $start + $this->count_on_page)? $start + $this->count_on_page: count($this->adm_messages);
        $text = "";
        for ($i = $start; $i < $end; $i++) {
            $text .= "<div class='col-md-12'>";
            $text .= "<div class=\"round-a-".$this->adm_messages[$i]["type"]."  col-md-12\">
            <div class='round-title col-md-8'>".$this->adm_messages[$i]["title"]."</div><div class='round-date col-md-4'>Добавлено: ".$this->formantDate($this->adm_messages[$i]["date"])."</div><div class='round-content col-md-12'>".htmlspecialchars_decode($this->adm_messages[$i]["short_desc"])."</div> ";
            $text .= "<div class='col-md-12 block-a'><a href=\"".$this->config->siteAddress."?view=one_message&id=".$this->adm_messages[$i]["id"]."\"><button class=\"btn btn-default\" style='float: right' >Подробнее</button></a></div></div></div>";
        }
        return $text;
    }

    private function formantDate($time) {
        return date("m-d H:i", $time);
    }

    protected function getBottom()
    {
        $page = (isset($this->data["page"]))? $this->data["page"]:1;
        return $this->getPagination(count($this->adm_messages), $this->count_on_page, $this->config->siteAddress."?view=messages", $page);
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
        $text .= "</ul></li>";
        if ($this->user_info["access_lvl"] == 2) {
            $text .= "<li class=\"dropdown active\">
                        <a class=\"dropdown - toggle\" data-toggle=\"dropdown\" href=\"#\">Сообщения<span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\" >
                            <li ><a href = \"".$this->config->siteAddress."?view=messages\" >Просмотр сообщений</a ></li >";
            $text .= "<li><a href=\"" . $this->config->siteAddress . "?view=add_message\" >Добавить новое сообщение</a ></li >";
            $text .= "</ul></li>";
        } else {
            $text .= "<li class='active'>
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