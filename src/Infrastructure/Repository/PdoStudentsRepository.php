<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentsRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeImmutable;
use PDO;

class PdoStudentsRepository implements StudentsRepository 
{
    private PDO $connection;
    
    public function __construct() 
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    public function allStudents(): array 
    {
        $statement = $this->connection->query("SELECT * FROM students");

        $studentsDataList = $statement->fetchAll(PDO::FETCH_ASSOC);

        $studentList = [];

        if(count($studentsDataList) >= 1) {
            foreach($studentsDataList as $studentDatas) {
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

    public function delete(Student $student): bool
    {
        $prepareStatement = $this->connection->prepare("DELETE FROM students WHERE id = :id;");
        $prepareStatement->bindValue(":id", $student->id(), PDO::PARAM_INT);
        return $prepareStatement->execute();
    }
}
