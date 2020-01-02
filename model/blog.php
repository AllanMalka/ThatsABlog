<?php
class Blog {
    public $bid;
    public $user;
    public $title;
    public $content;
    public $date_creation;
    public $date_update;
    
    function __construct(int $bid, User $user, string $title, string $content, $date_creation, $date_update) {
        $this->bid = $bid;
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
        $this->date_creation = $date_creation;
        $this->date_update = $date_update;
    }
}