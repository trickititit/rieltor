<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.07.2016
 * Time: 22:44
 */

    require_once "lib/database_class.php";
    require_once "lib/manager_class.php";

    $db = new DataBase();
    $manager = new Manager($db);
    if ($_POST["reg"]) {
        $r = $manager->regUser();
    }
    else if ($_POST["auth"]) {
        $r = $manager->login();
    }
    else if ($_GET["logout"]) {
        $r = $manager->logout();
    }
    else if ($_POST["create"]) {
        $r = $manager->addObject();
    }
    else if ($_POST["edit"]) {
        $r = $manager->editObject();
    }
    else if ($_GET["export"]) {
        $r = $manager->objExport();
    }
    else if ($_POST["edit_prf"]) {
        $r = $manager->editUser();
    }
    else if ($_POST["edit_prf_adm"]) {
        $r = $manager->editUserAdm();
    }
    else if ($_POST["create_comfort"]) {
        $r = $manager->addComfort();
    }
    else if ($_POST["create_adm_message"]) {
        $r = $manager->addAdmMessage();
    }
    else if ($_POST["edit_adm_message"]) {
        $r = $manager->editAdmMessage();
    }
    else exit;
    $manager->redirect($r);