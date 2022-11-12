<?php
namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use PDO;

require_once '../../vendor/autoload.php';

class SchoolClassController
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findingClasses(PdoSchoolClassRepository $schoolClassRepository,array $innerJoin): array
    {   
        $listOfClassses = [];

        foreach ($innerJoin as $row) {
            $listOfClassses[] = $schoolClassRepository->getClass($row['school_id']);
        }

        return $listOfClassses;
    }

    public function getAllClass(PdoSchoolClassRepository $schoolClassRepository): array
    {       
        return $schoolClassRepository->allClasses();
    }
}
?>