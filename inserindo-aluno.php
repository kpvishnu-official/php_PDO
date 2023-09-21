<?php

require_once "vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$student = new Student(
    id: null,
    name: "Joao",
    birthDate: new DateTime("2000-05-26"));

$sqlInsert = "INSERT INTO students (name, birth_date)
    VALUES  (:name, :birthDate);";

/* 
$sqlInsert = "DELETE FROM students";
$pdo->exec($sqlInsert);
exit();
*/

$stament = $pdo->prepare($sqlInsert);
$stament->bindValue(":name",  $student->name());
$stament->bindValue(":birthDate",  $student->birthDate()->format("Y-m-d"));

if($stament->execute()) {
    echo "Aluno inserido";
}
