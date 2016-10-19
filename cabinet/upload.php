<?php
require_once "../lib/database_class.php";
require_once "../lib/upload_class.php";


    $db = new DataBase();
    $upload = new Upload($db);

    $upload->UploadFile();
