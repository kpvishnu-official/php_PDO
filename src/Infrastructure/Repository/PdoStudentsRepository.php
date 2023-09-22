<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentsRepository;
use DateTimeImmutable;
use PDO;
use PDOStatement;
use RuntimeException;

class PdoStudentsRepository implements StudentsRepository 
{
    private PDO $connection;
    
    public function __construct(PDO $connection) 
    {
        $this->connection = $connection;
    }

    public function allStudents(): array 
    {
        $studentDataList = $this->connection->query("SELECT * FROM students");

        return $this->hydrateStudentsList($studentDataList);
    }

    public function hydrateStudentsList(PDOStatement $statement): array 
    {
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);

        $studentList = [];

        if(count($studentDataList) >= 1) {
            foreach($studentDataList as $studentDatas) {
                $studentList[] = new Student(
                $studentDatas['id'],
                $studentDatas['name'],
                new DateTimeImmutable($studentDatas["birth_date"]));
            }
        }

        return $studentList;
    }
    public function studentsBirthAt(DateTimeImmutable $birthDate): array
    {
        return [];
    }

    public function save(Student $student): bool 
    {

        if(is_null($student->id())) {
            return $this->insert($student);
        }

        return $this->update($student);  
    }

    private function insert(Student $student): bool 
    {
        $sqlInsert = "INSERT INTO students (name, birth_date)
        VALUES  (:name, :birthDate);";

        $statement = $this->connection->prepare($sqlInsert);
       
        $status = $statement->execute([
            ":name" =>  $student->name(), 
            ":birthDate" => $student->birthDate()->format("Y-m-d")
        ]);

        if ($status) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $status;
    }

    private function update(Student $student): bool 
    {
        $sqlInsert = "UPDATE students SET name = :name,  birth_date = :birth_date)
        VALUES  (:name, :birthDate);";

        $statement = $this->connection->prepare($sqlInsert);
        $status = $statement->execute([
            ":name" =>  $student->name(), 
            ":birthDate" => $student->birthDate()->format("Y-m-d")
        ]);

        return $status;
    }

    public function remove(Student $student): bool
    {
        $prepareStatement = $this->connection->prepare("DELETE FROM students WHERE id = :id;");
        $prepareStatement->bindValue(":id", $student->id(), PDO::PARAM_INT);
        return $prepareStatement->execute();
    }
}
