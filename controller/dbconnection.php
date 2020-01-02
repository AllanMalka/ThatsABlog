<?php
class dbConnection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "db_thatsablog";
    private $conn;
    private $tblUsers = "tblUsers";
    private $tblBlogs = "tblBlogs";

    function __construct(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        include_once "../model/user.php";
        include_once "../model/blog.php";
        //Checks if connection has errors
        if($this->conn->connect_error) 
            die("Connection Failed: " . $conn->connect_error);
    }

    #region Users
    function getAllUsers(){
        $conn = $this->conn;

        $query = "SELECT ID, userName, email, dateCreation FROM $this->tblUsers";
        $res = $conn->query($query);
        
        $users = [];
        if($res && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()){
                $users[] = new User($row["id"], $row["userName"], $row["email"], $row["dateCreation"]);
            }
        }
        $conn->close();

        return $users;
    }
    
    function getUserBy( $type, $param ){
        $conn = $this->conn;

        $query = "SELECT ID, userName, email, dateCreation FROM $this->tblUsers";
        switch ($type) {
            default:
            case 1:
                $query .= " WHERE ID = $param";
                break;
            case 2: 
                $query .= " WHERE userName = $param";
                break;
            case 3: 
                $query .= " WHERE email = $param";
                break;
        }

        $res = $conn->query($query);
        $user = "";
        if($res && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()){
                $user = new User($row["id"], $row["userName"], $row["email"], $row["dateCreation"]);
            }
        }
        $conn->close();

        return $user;
    }
    #endregion

    #region Blogs
    function getAllBlogs(){
        $conn = $this->conn;

        $query = "SELECT b.ID as BlogID, b.userID as UserID, b.title, b.content, b.dateCreation, b.dateUpdate, u.userName, u.email, u.dateCreation ";
        $query .= "FROM $this->tblBlogs b INNER JOIN tbUsers u ON b.uid = u.id";
        
        $res = $conn->query($query);
        
        $blogs = [];
        if($res && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()){
                $user = new User($row["UserID"], $row["userName"], $row["email"], $row["dateCreation"]);
                $blogs[] = new Blog($row["BlogID"], $user, $row["title"],$row["content"],$row["dateCreation"],$row["dateUpdate"]);
            }
        }
        $conn->close();

        return $blogs;
    }
    #endregion

    #region Creation
    function createTables(){
        if($this->createUserTables()){
            if($this->createBlogsTables()){
                $this->conn->close();
                return true;
            }
        }
        return false;
    }
    function createUserTables() {
        $conn = $this->conn;

        $query = "CREATE TABLE $this->tblUsers (
            ID INT NOT NULL AUTO_INCREMENT,
            userName VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL, 
            dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (ID)
        );";
        
        $res = $conn->query($query);
        return $res;
    }
    function createBlogsTables() {
        $conn = $this->conn;

        $query = " CREATE TABLE $this->tblBlogs (
            ID INT NOT NULL AUTO_INCREMENT,
            userID INT NOT NULL, 
            title VARCHAR(255) NOT NULL, 
            content VARCHAR(65535), 
            dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP, 
            dateUpdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (ID),
            FOREIGN KEY (userID) REFERENCES $this->tblUsers (ID)
        );";
        $res = $conn->query($query);
        return $res;
    }
    #endregion

    #region Test Data
    function insertTestData(){
        $conn = $this->conn;
        //password, hashing
        $query = "INSERT INTO users (username, email) VALUES 
                ('ghostperiodic', 'ghostperiodic@test.net', 'test'),
                ('yoyomanager', 'yoyomanager@test.net', 'test'),
                ('userfuzzy', 'userfuzzy@test.net', 'test'),
                ('reforestmenty', 'reforestmenty@test.net', 'test'),
                ('stonyslate', 'stonyslate@test.net', 'test'),
                ('brandyyen', 'brandyyen@test.net', 'test'),
                ('phoneprey', 'phoneprey@test.net', 'test'),
                ('canglingelect', 'canglingelect@test.net', 'test'),
                ('moorhensalsa', 'moorhensalsa@test.net', 'test'),
                ('collectcumbrian', 'collectcumbrian@test.net', 'test'),
                ('sankshrug', 'sankshrug@test.net', 'test'),
                ('kyanitetumb', 'kyanitetumb@test.net', 'test'),
                ('peanutprimary', 'peanutprimary@test.net', 'test'),
                ('catenaryprofit', 'catenaryprofit@test.net', 'test'),
                ('mewstingley', 'mewstingley@test.net', 'test'),
                ('strathmoremocolate', 'strathmoremocolate@test.net', 'test'),
                ('topsailevents', 'topsailevents@test.net', 'test'),
                ('blockedscrand', 'blockedscrand@test.net', 'test'),
                ('dealerdislocate', 'dealerdislocate@test.net', 'test'),
                ('dreamunhealthy', 'dreamunhealthy@test.net', 'test'),
                ('quesadillatesa', 'quesadillatesa@test.net', 'test'),
                ('mulleredwind', 'mulleredwind@test.net', 'test'),
                ('treasonvirtuous', 'treasonvirtuous@test.net', 'test'),
                ('sparrowclimatic', 'sparrowclimatic@test.net', 'test'),
                ('ceramicsmilo', 'ceramicsmilo@test.net', 'test')";
    }
    #endregion

    function showme($d, $e = false, $p = false){
        if($p) echo "<pre>";
        var_dump($d);
        if($p) echo "<pre>";
        if($e) exit;
    }
}