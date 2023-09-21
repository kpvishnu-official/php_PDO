<?php 

namespace Alura\Pdo\Domain\Repository;

use Alura\Pdo\Domain\Model\Student;
use DateTimeImmutable;

interface StudentsRepository 
{
    public function allStudents(): array;

    public function studentsBirthAt(DateTimeImmutable $birthDate): array;

    public function save(Student $student): bool;

    public function delete(Student $student): bool;  
}