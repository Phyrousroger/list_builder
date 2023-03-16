<?php

require_once "./core/connect.php";
require_once "./core/functions.php";

$tables=all("SHOW TABLES");
foreach ($tables as $table){
    run("DROP TABLE IF EXISTS ". $table["Tables_in_san_kyi_tar"]);
}

logger("All table dropped ");


createTable("my","name varchar(20) COLLATE utf8_unicode_ci NOT NULL","money int(11) NOT NULL");
createTable("inventories","name varchar(20) COLLATE utf8_unicode_ci NOT NULL","price int(11) NOT NULL","stock int(11) NOT NULL");
