<?php

// ================== REQUIRE ==================
require_once __DIR__ . '/../app/Core/Database.php';

require_once __DIR__ . '/../app/Repositories/TeamRepository.php';
require_once __DIR__ . '/../app/Repositories/TeamMemberRepository.php';
require_once __DIR__ . '/../app/Repositories/ProjectRepository.php';
require_once __DIR__ . '/../app/Repositories/TaskRepository.php';

require_once __DIR__ . '/../app/Services/TaskService.php';
require_once __DIR__ . '/../app/Services/ProjectService.php';

echo "=== TASKFLOW PART 2: WORKING DEMO ===\n\n";

// ================== CLEAN DATABASE ==================
echo " Cleaning database...\n";
$db = Database::getInstance()->getConnection();

$db->exec("SET FOREIGN_KEY_CHECKS = 0;");

// Supprimer les données (DELETE au lieu de TRUNCATE pour éviter les bugs sous XAMPP)
$db->exec("DELETE FROM tasks");
$db->exec("DELETE FROM projects");
$db->exec("DELETE FROM team_members");
$db->exec("DELETE FROM teams");

// Réinitialiser les compteurs auto_increment
$db->exec("ALTER TABLE teams AUTO_INCREMENT = 1");
$db->exec("ALTER TABLE team_members AUTO_INCREMENT = 1");
$db->exec("ALTER TABLE projects AUTO_INCREMENT = 1");
$db->exec("ALTER TABLE tasks AUTO_INCREMENT = 1");

// Réactiver les clés étrangères
$db->exec("SET FOREIGN_KEY_CHECKS = 1;");

echo "→ Database cleaned.\n\n";

// ================== INIT ==================
$teamRepo = new TeamRepository();
$memberRepo = new TeamMemberRepository();
$projectRepo = new ProjectRepository();
$taskRepo = new TaskRepository();

$taskService = new TaskService();
$projectService = new ProjectService();

// ================== 1. TEAM & MEMBERS ==================
echo "1. Creating Team and Members...\n";

$teamId = $teamRepo->save(['name' => 'Dev Team', 'description' => 'Development team']);
echo "    Team created with ID: $teamId\n";

$devId = $memberRepo->save([
    'username' => 'john_dev',
    'email' => 'john@company.com',
    'password_hash' => password_hash('123456', PASSWORD_DEFAULT),
    'role' => 'developer',
    'team_id' => $teamId
]);

$managerId = $memberRepo->save([
    'username' => 'jane_manager',
    'email' => 'jane@company.com',
    'password_hash' => password_hash('123456', PASSWORD_DEFAULT),
    'role' => 'manager',
    'team_id' => $teamId
]);

echo "    Members created (Dev ID: $devId, Manager ID: $managerId)\n\n";

// ================== 2. PROJECT ==================
echo "2. Creating Project...\n";

try {
    $projectService->createProject(
        ['name' => 'Invalid Project', 'team_id' => $teamId],
        'developer'
    );
} catch (Exception $e) {
    echo "  Rule enforced: " . $e->getMessage() . "\n";
}

$projectId = $projectService->createProject(
    ['name' => 'TaskFlow Project', 'team_id' => $teamId],
    'manager'
);

echo "   Project created successfully (ID: $projectId)\n\n";

// ================== 3. TASKS ==================
echo "3. Creating Tasks...\n";

$taskService->createTask([
    'title' => 'Login Feature',
    'description' => 'Implement login system',
    'project_id' => $projectId,
    'reporter_id' => $managerId,   
    'assignee_id' => null,
    'status' => 'open',
    'priority' => 'medium',
    'estimated_hours' => 5,
    'due_date' => null
]);

echo "   Normal task created\n";

try {
        $taskService->createTask([
        'title' => 'Critical Bug',
        'description' => 'System crash',
        'project_id' => $projectId,
        'reporter_id' => $managerId,   
        'assignee_id' => null,
        'status' => 'open',
        'priority' => 'critical',
        'estimated_hours' => 3,
        'due_date' => null
    ]);
} catch (Exception $e) {
    echo "   Rule enforced: " . $e->getMessage() . "\n";
}

echo "\n";

// ================== 4. ASSIGN TASK ==================
echo "4. Assigning Tasks...\n";

try {
    $taskService->assignTask(1, $devId, 'developer');
} catch (Exception $e) {
    echo "   Rule enforced: " . $e->getMessage() . "\n";
}

$taskService->assignTask(1, $devId, 'manager');
echo "   Task assigned successfully\n\n";

// ================== 5. STATUS UPDATE ==================
echo "5. Updating Task Status...\n";

try {
    $taskService->updateStatus(1, 'open', 'done');
} catch (Exception $e) {
    echo "   Rule enforced: " . $e->getMessage() . "\n";
}

$taskService->updateStatus(1, 'open', 'in_progress');
echo "   Task moved to 'in_progress'\n\n";

// ================== 6. REPORT ==================
echo "6. Generating Reports...\n";

$stats = $projectService->getProjectStats($projectId);
echo "   Total tasks: " . $stats['total_tasks'] . "\n";
echo "   Completed tasks: " . $stats['completed_tasks'] . "\n";

echo "\n=== DEMO COMPLETE ===\n";