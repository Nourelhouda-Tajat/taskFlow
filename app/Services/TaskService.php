<?php

require_once __DIR__ . '/../Repositories/TaskRepository.php';
require_once __DIR__ . '/../Core/Validator.php';

class TaskService
{
    private TaskRepository $taskRepo;

    public function __construct()
    {
        $this->taskRepo = new TaskRepository();
    }

    // Créer une tâche
    public function createTask(array $data): bool
    {
        if ($data['estimated_hours'] <= 0) {
            throw new Exception("Estimated hours must be positive");
        }

        if ($data['priority'] === 'critical' && empty($data['due_date'])) {
            throw new Exception("Critical task must have a due date");
        }

        if (!Validator::validateTaskStatus($data['status'])) {
            throw new Exception("Invalid task status");
        }

        return $this->taskRepo->save($data);
    }

    // Assigner une tâche
    public function assignTask(int $taskId, int $assigneeId, string $userRole): bool
    {
        if ($userRole !== 'manager') {
            throw new Exception("Only managers can assign tasks");
        }

        return $this->taskRepo->assignTask($taskId, $assigneeId);
    }

    // Mettre à jour le statut
    public function updateStatus(int $taskId, string $oldStatus, string $newStatus): bool
    {
        $allowedTransitions = [
            'open' => ['in_progress'],
            'in_progress' => ['done'],
            'done' => []
        ];

        if (!in_array($newStatus, $allowedTransitions[$oldStatus])) {
            throw new Exception("Invalid status transition");
        }

        return $this->taskRepo->updateStatus($taskId, $newStatus);
    }

    // Enregistrer des heures de travail
    public function logHours(int $taskId, int $hours): bool
    {
        if ($hours <= 0) {
            throw new Exception("Hours must be positive");
        }

        return $this->taskRepo->addHours($taskId, $hours);
    }
}
