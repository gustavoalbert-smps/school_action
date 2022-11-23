<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Interfaces\TeacherInterface;
use Alura\Pdo\Domain\Model\Teacher;
use DateTimeImmutable;
use PDO;

require_once '../../vendor/autoload.php';

class PdoTeacherRepository implements TeacherInterface
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getTeacher(int $id): Teacher
    {
        $sqlQuery = 'SELECT * FROM teachers WHERE id = :id';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute([
            ':id' => $id
        ]);

        $teacher = $statement->fetch(PDO::FETCH_ASSOC);

        $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id');
        $peopleStatement->execute([
            ':id' => $teacher['people_id']
        ]);

        $people = $peopleStatement->fetch(PDO::FETCH_ASSOC);

        return new Teacher(
            $teacher['id'], 
            $people['id'],
            $teacher['ability'],
            $people['name'], 
            $people['gender'], 
            new DateTimeImmutable($people['birth_date']), 
            $people['admin']);
    }

    public function getAllTeachers(): array
    {
        $sqlQuery = 'SELECT * FROM teachers';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute();

        $statementData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $teacherList = [];

        foreach ($statementData as $teacher) {
            $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id;');
            $peopleStatement->execute([':id' => $teacher['people_id']]);

            $people = $peopleStatement->fetch(PDO::FETCH_ASSOC);

            $teacherList[] = new Teacher(
                $teacher['id'],
                $teacher['people_id'],
                $teacher['ability'], 
                $people['name'], 
                $people['gender'], 
                new DateTimeImmutable($people['birth_date']), 
                $people['admin']
            );

        }

        return $teacherList;
    }

    public function getTeachersByGraduation(string $graduation): array
    {
        $sqlQuery = 'SELECT * FROM teacher WHERE ability = :graduation';

        $statement = $this->connection->prepare($sqlQuery);

        $statement->execute([
            ':ability' => $graduation
        ]);

        $statementData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $teacherList = [];

        foreach ($statementData as $teacher){
            $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id;');
            $peopleStatement->execute([':id' => $teacher['people_id']]);

            $people = $peopleStatement->fetch(PDO::FETCH_ASSOC);

            $teacherList[] = new Teacher(
                $teacher['id'],
                $teacher['people_id'],
                $teacher['ability'], 
                $people['name'], 
                $people['gender'], 
                new DateTimeImmutable($people['birth_date']), 
                $people['admin']
            );
        }
        
        return $teacherList;
    }

    public function teacherClasses(int $teacherId): array
    {
        $sqlQuery = 'SELECT matters.id as matter_id, teachers.id as teacher_id, school_classes.id as school_id FROM (
            (matters INNER JOIN teachers ON matters.teacher_id = :teacher_id)
            INNER JOIN school_classes ON matters.class_id = school_classes.id);';

        $statement = $this->connection->prepare($sqlQuery);
        
        $statement->execute([
            ':teacher_id' => $teacherId
        ]);

        $stData = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $stData;

    }

    public function getTeacherByPeopleId(int $peopleId): Teacher
    {
        $sqlQuery = 'SELECT * FROM teachers WHERE people_id = :id;';

        $statement = $this->connection->prepare($sqlQuery);
        
        $statement->execute([
            ':id' => $peopleId 
        ]);

        $teacher = $statement->fetch(PDO::FETCH_ASSOC);

        return $this->getTeacher($teacher['id']);
    }

    public function save(Teacher $teacher): bool
    {
        if ($teacher->getId() === null){
            return $this->insert($teacher);
        }

        return $this->update($teacher);
    }

    public function insert(Teacher $teacher): bool
    {
        $sqlInsert = 'INSERT INTO teachers (people_id, ability) VALUES (:people_id, :graduation);';

        $statement = $this->connection->prepare($sqlInsert);

        return $statement->execute([
            ':people_id' => $teacher->getPeopleId(),
            ':graduation' => $teacher->getGraduation()
        ]);
    }

    public function update(Teacher $teacher): bool
    {
        $sqlUpdate = 'UPDATE teachers SET people_id = :people_id, ability = :graduation WHERE id = :id;';

        $statement = $this->connection->prepare($sqlUpdate);

        return $statement->execute([
            ':people_id' => $teacher->getPeopleId(),
            ':graduation' => $teacher->getGraduation(),
            ':id' => $teacher->getId()
        ]);
    }

    public function remove(Teacher $teacher): bool
    {
        $sqlRemove = 'DELETE FROM teachers WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        return $statement->execute([
            ':id' => $teacher->getId()
        ]);
    }
}