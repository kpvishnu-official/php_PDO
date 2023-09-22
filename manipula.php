<?php
require_once "vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentsRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$connection = ConnectionCreator::createConnection();

$student = new Student(
    id: null,
    name: "Joao",
    birthDate: new DateTime("2000-05-26")
);

$pdoStudents = new PdoStudentsRepository($connection);

$pdoStudents->save($student);

$listStudents = $pdoStudents->allStudents();

var_dump($listStudents);