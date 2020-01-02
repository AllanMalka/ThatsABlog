<?php 

require_once "../controller/dbconnection.php";

$dbconn = new dbConnection();
$all_blogs = $dbconn->getAllBlogs();

if(!empty($all_blogs))
    return $all_blogs;
else 
    return null;