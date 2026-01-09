<?php

//test connexion Database
require_once 'app/Core/Database.php';

$pdo = Database::getInstance();
if ($pdo) {
    echo "Connexion etablie<br>";
} else {
    echo "Echec<br>";
}

// $result = $pdo->query("SELECT 'Hello' as test");
// $data = $result->fetch();
// echo $data['test'];



?>
