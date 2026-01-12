<?php

require_once __DIR__ . '/../Repositories/ProjectRepository.php';
require_once __DIR__ . '/../Repositories/TaskRepository.php';

class ProjectService
{
    private ProjectRepository $projectRepo;
    private TaskRepository $taskRepo;

    public function __construct()
    {
        $this->projectRepo = new ProjectRepository();
        $this->taskRepo = new TaskRepository();
    }

    // Créer un projet
    public function createProject(array $data, string $userRole): bool
    {
        if (!in_array($userRole, ['manager', 'admin'])) {
            throw new Exception("Only managers or admins can create projects");
        }

        if (empty($data['team_id'])) {
            throw new Exception("Project must belong to a team");
        }

        return $this->projectRepo->save($data);
    }

    // Statistiques du projet
    public function getProjectStats(int $projectId): array
    {
        $tasks = $this->taskRepo->findByProject($projectId);

        return [
            'total_tasks' => count($tasks),
            'completed_tasks' => count(
                array_filter($tasks, fn($t) => $t['status'] === 'done')
            )
        ];
    }

    // Archiver un projet
    public function archiveProject(int $projectId): bool
    {
        $activeTasks = $this->taskRepo->findByStatus('open');

        if (!empty($activeTasks)) {
            throw new Exception("Cannot archive project with active tasks");
        }

        return $this->projectRepo->archive($projectId);
    }
}
