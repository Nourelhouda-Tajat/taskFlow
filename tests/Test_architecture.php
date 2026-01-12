<?php

//test connexion Database

// require_once 'app/Core/Database.php';
// $pdo = Database::getInstance()->getConnection();
// print_r($pdo);
// if ($pdo) {
//     echo "Connexion etablie<br> hi";
// } else {
//     echo "Echec<br>";
// }
// $result = $pdo->query("SELECT * from tasks");
// $data = $result->fetchAll(PDO::FETCH_ASSOC);
// print_r($data);



echo "=== TASKFLOW PART 1: ARCHITECTURE VALIDATION ===<br><br>";

// Core
require_once __DIR__ . '/app/Core/Database.php';

// Interfaces
require_once __DIR__ . '/app/Interfaces/Assignable.php';
require_once __DIR__ . '/app/Interfaces/Prioritizable.php';
require_once __DIR__ . '/app/Interfaces/Commentable.php';

// Abstract classes
require_once __DIR__ . '/app/Entities/TeamMember.php';
require_once __DIR__ . '/app/Entities/Task.php';

// Team members
require_once __DIR__ . '/app/Entities/Developer.php';
require_once __DIR__ . '/app/Entities/Manager.php';

// Tasks
require_once __DIR__ . '/app/Entities/FeatureTask.php';
require_once __DIR__ . '/app/Entities/BugTask.php';


//
// Test 1: Singleton Database
//
echo "1. Testing Singleton Database:<br>";

try {
    $db1 = Database::getInstance();
    $db2 = Database::getInstance();

    if ($db1 === $db2) {
        echo "   PASS: Singleton works correctly (same instance)<br>";
    } else {
        echo "   FAIL: Singleton pattern broken<br>";
    }
} catch (Exception $e) {
    echo "   FAIL: " . $e->getMessage() . "<br>";
}

//
// Test 2: Inheritance Hierarchy (TeamMember)
//
echo "<br>2. Testing Inheritance Hierarchy:<br>";

try {
    $developer = new Developer("john_dev", "john@company.com", "password123", 1);
    $manager   = new Manager("jane_manager", "jane@company.com", "password123", 1);

    if ($developer instanceof TeamMember) {
        echo "   PASS: Developer extends TeamMember<br>";
    }

    if ($manager instanceof TeamMember) {
        echo "   PASS: Manager extends TeamMember<br>";
    }

    echo "   Developer can create project: "
        . ($developer->canCreateProject() ? 'Yes' : 'No')
        . " (expected: No)<br>";

    echo "   Manager can create project: "
        . ($manager->canCreateProject() ? 'Yes' : 'No')
        . " (expected: Yes)<br>";

} catch (Exception $e) {
    echo "   FAIL: " . $e->getMessage() . "<br>";
}

//
// Test 3: Task Hierarchy + Interfaces
//
echo "<br>3. Testing Task Hierarchy:<br>";

try {
    $featureTask = new FeatureTask(
        "New Login Feature",
        "Implement OAuth login",
        1,
        1
    );

    $bugTask = new BugTask(
        "Fix CSS Bug",
        "Button alignment issue",
        1,
        1
    );

    if ($featureTask instanceof Task) {
        echo "   PASS: FeatureTask extends Task<br>";
    }

    if ($bugTask instanceof Task) {
        echo "   PASS: BugTask extends Task<br>";
    }

    if ($featureTask instanceof Assignable) {
        echo "   PASS: FeatureTask implements Assignable<br>";
    }

    if ($bugTask instanceof Prioritizable) {
        echo "   PASS: BugTask implements Prioritizable<br>";
    }

} catch (Exception $e) {
    echo "   FAIL: " . $e->getMessage() . "<br>";
}

//
// Test 4: Abstract Class Protection
//
echo "<br>4. Testing Abstract Class Instantiation Prevention:<br>";

try {
    $task = new Task();
    echo "   FAIL: Abstract class Task should not be instantiated<br>";
} catch (Error $e) {
    echo "   PASS: Cannot instantiate abstract Task class<br>";
}

echo "<br>=== VALIDATION COMPLETE ===<br>";
echo "If all tests pass, you're ready for Part 2!<br>";


?>
