<?php

require_once 'BaseRepository.php';

class TeamMemberRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('team_members');
    }

    public function save(array $data): bool
    {
        $sql = "INSERT INTO team_members (username, email, password_hash, team_id)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['username'],
            $data['email'],
            $data['password_hash'],
            $data['team_id']
        ]);
    }
}
