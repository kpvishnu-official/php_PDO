<?php
require_once "vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentsRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$connection = ConnectionCreator::createConnection();
$studentsRepository = new PdoStudentsRepository($connection);

$StudentsDatasList = [
    ["name" => "aluno1", "birthDate" => new DateTime("2000-05-26")],
    ["name" => "aluno3", "birthDate" => new DateTime("1999-05-26")],
    ["name" => "alono4", "birthDate" => new DateTime("1998-05-26")],
    ["name" => "aluno5", "birthDate" => new DateTime("2001-05-26")],
    ["name" => "aluno6", "birthDate" => new DateTime("2002-05-26")],
];

$connection->beginTransaction();

try {   
    foreach ($StudentsDatasList as $StudentData) {
        $student = new Student(
            id: null,
            name: $StudentData["name"],
            birthDate: $StudentData["birthDate"],
        );
        $studentsRepository->save($student);
    }
    $connection->commit();
    echo "Insert new alunos list;";
} catch (PDOException $e) {
    echo $e->getMessage();
    $connection->rollBack();
}
