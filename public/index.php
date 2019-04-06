<?php
session_start();

/**
* Connect database
*/
require_once __DIR__ . "/../mvc/Model/Db.php";
$db = new Db();
$connectionDb = $db->getConnection();


/**
* Connect route
*/
require_once __DIR__ . "/../mvc/Model/Route.php"; 
Route::start($connectionDb);
