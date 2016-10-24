<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 17.10.2016
 * Time: 17:45
 */
require_once "modules_class.php";

class ViewMainPageContent extends Modules {

    private $objects;
    private $images;
    private $users;
    private $comforts;
    private $comforts_;
    private $creater;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->objects = $this->object->get($this->data["id"]);//пердать id пользователя
        $this->images = $this->image->getAllOnObjID($this->data["id"]);
        $this->users = $this->user->getAll();
        $this->comforts = $this->comfort->getAll();
        $this->comforts_ = $this->object->getAllComfortsOnObj($this->data["id"]);
        $this->creater = $this->user->get($this->objects["created_id"]);
    }

    protected function getTitle()
    {
        
    }

    protected function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    protected function getKeywords()
    {
        // TODO: Implement getKeywords() method.
    }

    protected function getTop()    {


    }    
    

    protected function getMenu()
    {
        // TODO: Implement getMenu() method.
    }

    protected function getMiddle()
    {
        // TODO: Implement getMiddle() method.
    }

    protected function getBottom()
    {
        // TODO: Implement getBottom() method.
    }

    protected function getNavMenu()
    {
        // TODO: Implement getNavMenu() method.
    }
}