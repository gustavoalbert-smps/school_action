<?php
namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\Teacher;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use DateTimeImmutable;
use PDO;

require_once '../../vendor/autoload.php';

class TeacherController
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAllTeachers(PdoTeacherRepository $teacherRepository): array
    {
        $teachers = $teacherRepository->getAllTeachers();

        return $teachers;
    }

    public function insertTeacher(PdoTeacherRepository $teacherRepository, int $peopleId, string $graduation, string $name, string $gender, string $birthDate, int $isAdmin) 
    {
        $teacher = new Teacher(null, $peopleId, $graduation, $name, $gender, new DateTimeImmutable($birthDate), $isAdmin);

        return $teacherRepository->save($teacher);
    }

    public function teacherClasses(PdoTeacherRepository $teacherRepository,int $teacherId): array
    {
        return $teacherRepository->teacherClasses($teacherId);
    }

    public function getTeacherWithPeopleId(PdoTeacherRepository $teacherRepository, int $peopleId): Teacher
    {
        return $teacherRepository->getTeacherByPeopleId($peopleId);
    }
}
?>