<?php

use Alura\Pdo\Infrastructure\Repository\PdoStudentsRepository;

require_once "vendor/autoload.php";

$students = new PdoStudentsRepository();

$alunos = $students->allStudents();

var_dump($alunos);