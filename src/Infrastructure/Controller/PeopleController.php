<?php

namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\People;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use DateTimeImmutable;
use PDO;

require_once '../../vendor/autoload.php';

class PeopleController 
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getPeople(PdoPeopleRepository $peopleRepository, int $id): People
    {
        return $peopleRepository->getPeople($id);
    }

    public function insertPeople(PdoPeopleRepository $peopleRepository, string $name, string $gender, string $birthDate, int $admin): People
    {
        $people = new People(null, $name, $gender, new DateTimeImmutable($birthDate), $admin);

        $peopleRepository->save($people);

        return $people;
    }
    
    public function updatePeople(PdoPeopleRepository $peopleRepository, int $id, string $name, string $gender, DateTimeImmutable $birthdate, int $admin, string $job,string $phone, string $email): bool
    {
        $people = new People(
            $id,
            $name,
            $gender,
            $birthdate,
            $admin
        );

        return $peopleRepository->save($people);
    }

    public function removePeople(PdoPeopleRepository $peopleRepository, People $people): bool
    {
        return $peopleRepository->remove($people);
    }
}