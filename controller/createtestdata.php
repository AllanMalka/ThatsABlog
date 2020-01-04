<?php

require_once "../controller/dbconnection.php";

$dbconn = new dbConnection();
$dbconn->insertTestData();