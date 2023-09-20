<?php

require_once "vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . "/banck.sqlite";
$pdo = new PDO("sqlite:" . $databasePath);

$student = new Student(
    id: null,
    name: "Joao",
    birthDate: new DateTime("2002-12-17")
);

$sqlInsert = "INSERT INTO students (name, birth_date)
    VALUES  (
        '{$student->name()}',
        '{$student->birthDate()->format('Y-m-d')}'
    )
";

var_dump($pdo->exec($sqlInsert));
