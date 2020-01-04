<?php 

require_once "../controller/dbconnection.php";

$dbconn = new dbConnection();
$all_blogs = $dbconn->getAllBlogs();

if(!empty($all_blogs))
    echo json_encode($all_blogs);
else 
    echo "";
die;