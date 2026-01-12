<?php

require_once 'BaseRepository.php';

class TeamMemberRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('team_members');
    }

     public function save(array $data): int
    {
        $sql = "INSERT INTO team_members (username, email, password_hash, role, team_id) 
                VALUES (:username, :email, :password_hash, :role, :team_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
}
