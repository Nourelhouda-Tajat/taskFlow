<?php 
class Manager extends TeamMember{
    public function __construct(string $username, string $email, string $password, int $team_id) {
        parent::__construct($username, $email, $password, $team_id, 'manager');
    }
    public function canCreateProject(): bool{
        return true;
    }
    public function canAssignTasks(): bool{
        return true;
    }
    public function getRolePermissions(): array{
        return ['create_projects', 'assign_tasks'];
    }
}
?>