<?php
require_once "../lib/database_class.php";
require_once "../lib/favorites_class.php";


    $db = new DataBase();
    $favorites = new Favorites($db);
    if (isset($_REQUEST["addfav"])){
        $favorites->addFavorites();
    } else if (isset($_REQUEST["delfav"])) {
        $favorites->deleteFavorites();
    }
        


