<?php

namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\People;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;

use PDO;

require_once '../../vendor/autoload.php';

class PeopleController 
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getPeople($peopleRepository,$id): People
    {
        return $peopleRepository->getPeople($id);
    }
}