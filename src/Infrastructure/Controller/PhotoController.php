<?php
namespace Alura\Pdo\Infrastructure\Controller;

use Alura\Pdo\Domain\Model\Photo;
use Alura\Pdo\Infrastructure\Repository\PdoPhotoRepository;
use PDO;
   
require_once '../../vendor/autoload.php';
   
class PhotoController 
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;   
    }

    public function Photo(PdoPhotoRepository $PhotoRepository, int $people_id): Photo
    {
        return $PhotoRepository->getPhoto($people_id);
    }
    public function insertPhoto($PhotoRepository,$people_id,$file)
    {
        return $PhotoRepository->insert($people_id,$file);
    }
    public function deletePhoto(PdoPhotoRepository $PhotoRepository, Photo $photo)
    {
        return $PhotoRepository->remove($photo);
    }
    public function countPhoto(PdoPhotoRepository $PhotoRepository,$id): int
    {
        return $PhotoRepository->countPhoto($id);
    }
    public function size(PdoPhotoRepository $PhotoRepository, int $altura , int $largura)
    {
        return $PhotoRepository->resize($photo, $altura, $largura);
    } 
}
