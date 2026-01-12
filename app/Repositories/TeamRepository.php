<?php

require_once 'BaseRepository.php';

class TeamRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('teams');
    }

    public function save(array $data): bool
    {
        $sql = "INSERT INTO teams (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name']]);
    }
}
