<?php

abstract class TeamMember {
    private ?int $id; 
    private string $username;
    private string $email;
    private string $password;
    private string $role;
    private int $team_id;
    private DateTime $createdAt;

    public function __construct($id, $username, $email, $password, $role, $team_id, $createdAt){
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->teamId = $teamId;
        $this->password = $password;
        $this->role = $role;
        $this->createdAt = new DateTime();
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