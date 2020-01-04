<?php
class dbConnection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "db_thatsablog";
    private $conn;
    private $tblUsers = "tblusers";
    private $tblBlogs = "tblblogs";

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

        $query = "SELECT b.ID as BlogID, b.userID, b.title, b.content, b.dateCreation, b.dateUpdate, u.userName, u.email, u.dateCreation ";
        $query .= "FROM $this->tblBlogs b INNER JOIN $this->tblUsers u ON b.userID = u.ID";

        $res = $conn->query($query);
        
        $blogs = [];
        if($res && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()){
                $user = new User($row["userID"], $row["userName"], $row["email"], $row["dateCreation"]);
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
            password VARCHAR(255) NOT NULL,
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
        
        $query = "INSERT INTO $this->tblUsers (username, email, password) VALUES";
        $query .= " ('ghostperiodic', 'ghostperiodic@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('yoyomanager', 'yoyomanager@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('userfuzzy', 'userfuzzy@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('reforestmenty', 'reforestmenty@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('stonyslate', 'stonyslate@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('brandyyen', 'brandyyen@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('phoneprey', 'phoneprey@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('canglingelect', 'canglingelect@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('moorhensalsa', 'moorhensalsa@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('collectcumbrian', 'collectcumbrian@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('sankshrug', 'sankshrug@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('kyanitetumb', 'kyanitetumb@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('peanutprimary', 'peanutprimary@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('catenaryprofit', 'catenaryprofit@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('mewstingley', 'mewstingley@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('strathmoremocolate', 'strathmoremocolate@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('topsailevents', 'topsailevents@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('blockedscrand', 'blockedscrand@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('dealerdislocate', 'dealerdislocate@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('dreamunhealthy', 'dreamunhealthy@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('quesadillatesa', 'quesadillatesa@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('mulleredwind', 'mulleredwind@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('treasonvirtuous', 'treasonvirtuous@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('sparrowclimatic', 'sparrowclimatic@test.net', '".password_hash("test", PASSWORD_BCRYPT )."'),";
        $query .= " ('ceramicsmilo', 'ceramicsmilo@test.net', '".password_hash("test", PASSWORD_BCRYPT )."')";
        $res = $conn->query($query);
        if($res){
            $query = "INSERT INTO $this->tblBlogs (userID, title, content) VALUES";
            $query .= " ('1', 'Test', 'Bacon ipsum dolor amet flank doner pork swine ham frankfurter tri-tip, venison strip steak porchetta sausage picanha kevin. Burgdoggen chicken cupim pork drumstick, spare ribs pork loin sausage t-bone hamburger. T-bone andouille filet mignon, pork loin strip steak rump frankfurter burgdoggen turducken. Cow prosciutto bacon, pastrami spare ribs buffalo cupim beef ribs beef t-bone doner ball tip sausage pork capicola. Pork chop sirloin shoulder burgdoggen chuck. Short ribs cow shankle ribeye tri-tip pastrami burgdoggen.')";
            $res = $conn->query($query);
        }
        $conn->close();
        return $res;
    }
    #endregion

    function showme($d, $e = false, $p = false){
        if($p) echo "<pre>";
        var_dump($d);
        if($p) echo "<pre>";
        if($e) exit;
    }
}