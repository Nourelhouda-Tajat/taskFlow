<?php

require_once 'BaseRepository.php';

class ProjectRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('projects');
    }

    public function save(array $data): bool
    {
        $sql = "INSERT INTO projects (name, team_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['name'],
            $data['team_id']
        ]);
    }
}
