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
        // Ensure required fields are present
        if (!isset($data['reporter_id'])) {
            throw new InvalidArgumentException("Missing required field: reporter_id");
        }

        $sql = "INSERT INTO tasks (
                    title, 
                    description, 
                    project_id, 
                    assignee_id, 
                    reporter_id, 
                    status, 
                    priority, 
                    estimated_hours, 
                    actual_hours, 
                    due_date
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['project_id'] ?? null,
            $data['assignee_id'] ?? null,
            $data['reporter_id'], // ← REQUIRED
            $data['status'] ?? 'open',
            $data['priority'] ?? 'medium',
            $data['estimated_hours'] ?? 0,
            $data['actual_hours'] ?? null,
            $data['due_date'] ?? null
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
