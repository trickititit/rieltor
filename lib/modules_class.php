<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 1:56
 */

require_once "config_class.php";
require_once "post_class.php";
require_once "section_class.php";
require_once "object_class.php";
require_once "user_class.php";
require_once "comfort_class.php";
require_once "adm_message_class.php";
require_once "message_class.php";
require_once "admmenu_class.php";
require_once "images_class.php";

abstract class Modules {
    protected $config;
    protected $post;
    protected $section;
    protected $object;
    protected $user;
    protected $comfort;
    protected $message;
    protected $adm_menu;
    protected $data;
    protected $user_info;
    protected $image;
    protected $adm_message;

    public function __construct($db)
    {
        session_start();
        $this->config = new Config();
        $this->post = new Post($db);
        $this->section = new Section($db);
        $this->object = new Object($db);
        $this->user = new User($db);
        $this->comfort = new Comfort($db);
        $this->message = new Message();
        $this->adm_menu = new AdmMenu($db);
        $this->adm_message = new AdmMessage($db);
        $this->data = $this->secureData($_GET);
        $this->user_info = $this->getUser();
        $this->image = new Images($db);
    }

    private function getUser(){
        $login = $_SESSION["login"];
        $password = $_SESSION["password"];
        if ($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
        else return false;
    }


    public function getContent(){
        if (!$this->user_info) {
           $this->redirect($this->config->siteAddress."login.php");
        }       
        $sr["title"] = $this->getTitle();
        $sr["meta_desc"] = $this->getDescription();
        $sr["meta_key"] = $this->getKeywords();
        $sr["nav_menu"] = $this->getNavMenu();
        $sr["adm_menu"] = $this->getMenu();
        $sr["top"] =  $this->getTop();
        $sr["message"] = $this->getMessage();
        $sr["middle"] = $this->getMiddle();
        $sr["bottom"] = $this->getBottom();
        $sr["username"] = $this->getUserName();
        $sr["editprofile"] = "&id=".$this->user_info["id"];
        return $this->getReplaceTemplate($sr, "main");
    }

    private function redirect($link) {
        header("Location: $link");
        exit;
    }

    abstract protected function getNavMenu();
    abstract protected function getTitle();
    abstract protected function getDescription();
    abstract protected function getKeywords();
    abstract protected function getTop();
    abstract protected function getMenu();
    abstract protected function getMiddle();
    abstract protected function getBottom();
    protected function getUserName(){
        if ($this->user_info["access_lvl"] == 2) $rang = "Директор";
        else $rang = "Риелтор";
        return $rang." ".$this->user_info["name"];
    }

    private function secureData($data){
        foreach ($data as $key => $value) {
            if (is_array($value)) $this->secureData($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    protected function getPagination($count, $count_on_page, $link, $page){
        $count_on_pages = ceil($count / $count_on_page);
        $sr["number"] = 1;
        $sr["link"] = $link;
        if ($page == 1) {
            $sr["active"] = "active";
        }
        $pages = $this->getReplaceTemplate($sr, "number_page");
        $sym = (strpos($link, "?") !== false)? "&amp;": "?";
        for ($i = 2; $i <= $count_on_pages; $i++) {
            if ($i == $page) {
                $sr["active"] = "active";
            } else {
                $sr["active"] = "";
            }
            $sr["number"] = $i;
            $sr["link"] = $link.$sym."page=$i";
            $pages .= $this->getReplaceTemplate($sr, "number_page");
        }
        $els["number_pages"] = $pages;
        return $this->getReplaceTemplate($els, "pagination");

    }

    protected function getMessage() {
        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
            $type_message = $_SESSION["type_message"];
            $search_count = (isset($_SESSION["search_count"]))? $_SESSION["search_count"]: "";
            unset($_SESSION["message"]);
            unset($_SESSION["type_message"]);
            unset($_SESSION["search_count"]);
            $sr["message"] = "<script type=\"text/javascript\">
                $().toastmessage('showToast', {
        text     : \"".$this->message->getText($message)." ".$search_count."\",
        sticky   : true,
        position : 'top-right',
        type     : \"".$type_message."\",
        closeText: '',
        close    : function () {
                console.log(\"toast is closed ...\");
            }
    });
</script>";
        } else {
            $sr["message"] = "";
        }
        return $this->getReplaceTemplate($sr, "messages");
    }

    protected function getTemplateOnly($name)
    {
        return file_get_contents($this->config->dir_tmpl . $name . ".tpl");
    }

    protected function getTemplate($name){
        $text = file_get_contents($this->config->dir_tmpl.$name.".tpl");
        return str_replace("%address%", $this->config->siteAddress, $text);
    }

    protected function getReplaceTemplate($sr, $template) {
        return $this->getReplaceContent($sr, $this->getTemplate($template));
    }

    private function getReplaceContent($sr, $content) {
        $search = array();
        $replace = array();
        $i = 0;
        foreach ($sr as $key => $value){
            $search[$i] = "%$key%";
            $replace[$i] = $value;
            $i++;
        }
        return str_replace($search, $replace, $content);
    }

}