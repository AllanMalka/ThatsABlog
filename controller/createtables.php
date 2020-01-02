<?php

require_once "../controller/dbconnection.php";


$dbconn = new dbConnection();
$res = $dbconn->createTables();

return $res;