<?php

require_once "../lib/database_class.php";
require_once "../lib/delete_class.php";


$db = new DataBase();
$delete = new Delete($db);

$delete->DeleteFile();


