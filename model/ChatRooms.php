<?php

class ChatRooms {
    public $chatroomId;
    public $name;
    public $description;
    public $photoUrl;
    public $totalUsers;
    public $private;

    public function __construct($chatroomId, $name, $description, $photoUrl, $totalUsers, $private) {
        $this->chatroomId = $chatroomId;
        $this->name = $name;
        $this->description = $description;
        $this->photoUrl = $photoUrl;
        $this->totalUsers = $totalUsers;
        $this->private = $private;
    }
}
?>
