<?php

require_once 'BaseRepository.php';

class TaskRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('tasks');
    }

    public function save(array $data): bool
    {
        $sql = "INSERT INTO tasks (title, description, project_id, assignee_id, status)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['project_id'],
            $data['assignee_id'],
            $data['status']
        ]);
    }

    public function findByAssignee(int $assigneeId): array
    {
        $sql = "SELECT * FROM tasks WHERE assignee_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$assigneeId]);

        return $stmt->fetchAll();
    }

    public function findByProject(int $projectId): array
    {
        $sql = "SELECT * FROM tasks WHERE project_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$projectId]);

        return $stmt->fetchAll();
    }

    public function findByStatus(string $status): array
    {
        $sql = "SELECT * FROM tasks WHERE status = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status]);

        return $stmt->fetchAll();
    }

    public function assignTask(int $taskId, int $assigneeId): bool
    {
        $sql = "UPDATE tasks SET assignee_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$assigneeId, $taskId]);
    }
}


// $taskRepo = new TaskRepository();

// $tasks = $taskRepo->findByStatus('active');
// var_dump($tasks);
