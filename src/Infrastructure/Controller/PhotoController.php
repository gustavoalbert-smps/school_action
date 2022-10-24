<?php


namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\Photo;
use Alura\Pdo\Infrastructure\Repository\PdoPhotoRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use DateTimeImmutable;
use PDO;
   
require_once '../../vendor/autoload.php';
   
class PhotoController 
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
     $this -> connection = $connection;   
    }

    public function Photo(PdoPhotoRepository $PhotoRepository, int $id): Photo
    {
        return $PhotoRepository->getPhoto($id);
    }  
}
