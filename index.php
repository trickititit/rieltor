<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 04.08.2016
 * Time: 22:47
 */

mb_internal_encoding("UTF-8");
require_once "lib/database_class.php";
require_once "lib/frontpagecontent_class.php";
require_once "lib/regcontent_class.php";
require_once "lib/messagecontent_class.php";
require_once "lib/editobjcontent_class.php";
require_once "lib/createobjcontent_class.php";
require_once  "lib/editprofilecontent_class.php";
require_once "lib/comfortcontent_class.php";
require_once "lib/favoritescontent_class.php";
require_once  "lib/doit_class.php";
require_once  "lib/mainpagecontent_class.php";
require_once "lib/config_class.php";

$config = new Config();
$link = $config->siteAddress."cabinet/";
header("Location: $link");
$db = new DataBase();
$view = $_GET["view"];
$do = $_GET["do"];
if(isset($do)) {
    $doit = new doIt($db);
    switch ($do) {
        case "in_pre_work": $doit->doInPreWork();
            break;
        case "in_work": $doit->doInWork();
            break;
        case "cancel_in_work": $doit->doCancelInWork();
            break;
        case "cancel_work": $doit->doCancelWork();
            break;
        case "cancel_delete": $doit->doCancelDelete();
            break;
        case "delete": $doit->doDelete();
            break;
        case "pre_delete": $doit->doPreDelete();
            break;
        case "fav_del": $doit->doFavDelete();
            break;
        default: break;
    }
}

switch ($view) {
    case "": $content = new ViewMainPageContent($db);
        break;
    case "reg": $content = new RegPageContent($db);
        break;
    case "profileedit": $content = new EditProfileContent($db);
        break;
    case "message": $content = new MessageContent($db);
        break;
    case "objedit": $content = new EditObjContent($db);
        break;
    case "objcreate": $content = new CreateObjContent($db);
        break;
    case "comfort": $content = new ComfortContent($db);
        break;
    case "favorites": $content = new FavoritesContent($db);
        break;
    default: exit;
}

echo $content->getContent();