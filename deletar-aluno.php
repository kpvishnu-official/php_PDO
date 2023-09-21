<?php

require_once "vendor/autoload.php";

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();
$sqlDelete = "DELETE FROM students WHERE id = :id;";

$prepareStatement = $pdo->prepare($sqlDelete);

$prepareStatement->bindValue(":id", '1', PDO::PARAM_INT);

if($prepareStatement->execute()) {
    echo "Aluno deletado";
}
