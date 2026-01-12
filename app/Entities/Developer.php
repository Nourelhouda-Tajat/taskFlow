<?php 
class Developer extends TeamMember{
    public function __construct(string $username, string $email, string $password, int $team_id) {
        parent::__construct($username, $email, $password, $team_id, 'developer');
    }
    public function canCreateProject(): bool{
        return false;
    }
    public function canAssignTasks(): bool{
        return false;
    }
    public function getRolePermissions(): array{
        return ['work_on_tasks'];
    }
}
?>