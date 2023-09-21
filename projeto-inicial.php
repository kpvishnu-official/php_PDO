<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Henrique',
    new \DateTimeImmutable('200-03-25')
);

echo $student->age();
