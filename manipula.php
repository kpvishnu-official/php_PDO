<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentsRepository;

require_once "vendor/autoload.php";


$student = new Student(
    id: null,
    name: "Joao",
    birthDate: new DateTime("2000-05-26")
);

$pdoStudents = new PdoStudentsRepository();

$pdoStudents->save($student);

$listStudents = $pdoStudents->allStudents();

var_dump($listStudents);