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

    public function Photo(PdoPhotoRepository $PhotoRepository, int $id): Photo
    {
       
        return $PhotoRepository->getPhoto($id);
    }
    public function insertPhoto($PhotoRepository,$people_id,$file)
    {
        return $PhotoRepository->insert($people_id,$file);
    }
    public function PhotoIf(PdoPhotoRepository $PhotoRepository,$id)
    {
        return $PhotoRepository->checkPhoto($id);
    } 
}
