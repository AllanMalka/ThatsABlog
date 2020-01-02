<?php 
class User {
    public $uid;
    public $username;
    public $email;
    public $date_creation;

    function __construct(int $uid, string $username, string $email, $date_creation){
        $this->uid = $uid;
        $this->username = $username;
        $this->email = $email;
        $this->date_creation = $date_creation;
    }

}