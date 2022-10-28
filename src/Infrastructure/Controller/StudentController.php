<?php

namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use PDO;

require_once '../../vendor/autoload.php';

class StudentController 
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getStudent(PdoStudentRepository $studentRepository, int $id): Student
    {
        return $studentRepository->getStudent($id);
    }

    public function numberOfStudentsByClass(PdoStudentRepository $studentRepository, int $classId): int
    {
        return $studentRepository->countStudentsByClass($classId);
    }

    public function removeStudent(PdoStudentRepository $studentRepository, Student $student): bool
    {
        return $studentRepository->remove($student);
    }
}