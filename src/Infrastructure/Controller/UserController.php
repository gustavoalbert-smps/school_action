<?php 

namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\User;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use PDO;

require_once '../../vendor/autoload.php';

class UserController
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {   
        $this->connection = $connection;
    }

    public function getUserWithPeopleId(PdoUserRepository $userRepository, int $peopleId): User
    {
        return $userRepository->getUserByPeopleId($peopleId);
    }

    public function totalUsers(PdoPeopleRepository $peopleRepository): int
    {
        return $peopleRepository->getAllPeopleCount();
    }

    public function Users(PdoPeopleRepository $peopleRepository): array
    {
        return $peopleRepository->getAllPeople();
    }

    public function totalUsersType(string $user): int
    {
        if  ($user === 'teacher') {
            $sqlQuery = 'SELECT people.id, users.id, teachers.id FROM (
                (people INNER JOIN users ON people.id = users.people_id)
                INNER JOIN teachers ON people.id = teachers.people_id);';
    
            $statement = $this->connection->prepare($sqlQuery);
            $statement->execute();
    
            return count($statement->fetchAll(PDO::FETCH_ASSOC));
        }

        $sqlQuery = 'SELECT people.id, users.id, students.id FROM (
            (people INNER JOIN users ON people.id = users.people_id)
            INNER JOIN students ON people.id = students.people_id);';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute();

        return count($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function removeUser(PdoUserRepository $userRepository, User $user): bool
    {
        return $userRepository->remove($user);
    }
}