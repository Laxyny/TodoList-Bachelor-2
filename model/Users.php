<?php

class Users {
    public $userId;
    public $email;
    public $user;
    public $password;
    public $gender;
    public $birthday;
    public $location;
    public $photoUrl;
    public $online;
    public $role;

    public function __construct($userId, $email, $user, $password, $gender, $birthday, $location, $photoUrl, $online, $role) {
        $this->userId = $userId;
        $this->email = $email;
        $this->user = $user;
        $this->password = $password;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->location = $location;
        $this->photoUrl = $photoUrl;
        $this->online = $online;
        $this->role = $role;
    }

}
?>
