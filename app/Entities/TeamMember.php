<?php

abstract class TeamMember {
    private ?int $id; 
    private string $username;
    private string $email;
    private string $password;
    private string $role;
    private int $teamId;
    private DateTime $createdAt;

    public function __construct($username, $email, $password, $teamId, $role){
        // $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->teamId = $teamId;
        $this->password = $password;
        $this->role = $role;
        $this->createdAt = new DateTime('today');
    }

    abstract function canCreateProject();
    abstract function canAssignTasks();
    abstract function getRolePermissions();

    public function verifyPassword(string $pass){
        if ($this->password === $pass) {
            return true;
        }
        return false;

    }
    public function setPassword(string $pass){
        $this->password = $pass;
    }
}

?>