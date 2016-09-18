<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 11.07.2016
 * Time: 21:18
 */

require_once "modules_class.php";

class EditProfileContent extends Modules {
    private $user_;
   


    public function __construct($db)
    {
        parent::__construct($db);
        $this->user_ = $this->user->get($this->data["id"]);
        

    }

    protected function getTitle()
    {
        return "Редактирование пользователя";
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

    protected function getMiddle()
    {        
        $sr["script"] = $this->getScript();
        $sr["submit"] = $this->getSubmit();
        return $this->getReplaceTemplate($sr, "profile_edit");
    }
    
    private function getScript() {
        $script = "$('#login input').val(\"".$this->user_["login"]."\");
        $('#name input').val(\"".$this->user_["name"]."\");
        $('#email input').val(\"".$this->user_["email"]."\");
        $('#contact input').val(\"".$this->user_["contact"]."\");";
        return $script;
    }

    private function getSubmit() {
        if ($this->user_["trust"] == 0) {
            $trust = "<option value='1'>Есть</option>
                      <option selected value='0'>Отсутствует</option>";
        } else {
            $trust = "<option selected value='1'>Есть</option>
                      <option value='0'>Отсутствует</option>";
        }
        if ($this->user_info["access_lvl"] == 2) {
            $text = "<li>
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div id=\"trust\">
                            <label for=\"edit_contact\">Доверие</label>
                            <select name=\"edit_trust\" id='trust'>
                            ".$trust."
                            </select>
                        </div>
                    </div>
                </div>
                </li>
                <li>
                <div class=\"submit\">
                    <input class=\"submit\" type=\"submit\" name=\"edit_prf_adm\" value=\"Редактировать\">
                </div>
            </li>";
        } else {
            $text = "<li>
                <div class=\"submit\">
                    <input class=\"submit\" type=\"submit\" name=\"edit_prf\" value=\"Редактировать\">
                </div>
            </li>";
        }
        return $text;

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