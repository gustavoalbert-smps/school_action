<?php
namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\Teacher;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use PDO;

require_once '../../vendor/autoload.php';

class TeacherController
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
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