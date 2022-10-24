<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Interfaces\PhotoInterface;
use Alura\Pdo\Domain\Model\Photo;
use PDO;

require_once '../../vendor/autoload.php';

class PdoPhotoRepository implements PhotoInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    // public function getPath(int $id): Photo
    // {
    //     $sqlquery = ""
    // }
    public function insert(Photo $photo): bool
    {
        $sqlInsert = 'INSERT photos (path, people_id) value (:path,:people_id)';

        $statement = $this->connection->prepare($sqlInsert);

        return $statement-> execute([
            ':path'=> $photo->getPath(),
            'people_id' => $photo->getPhotoPeopleId()
        ]);
    }
    public function update (Photo $photo): bool
    {
        $sqlUpdate = 'UPDATE photos SET path = :path, people_id = :people_id WHERE id = :id';

        $statement = $this->connection->prepare($sqlUpdate);

        return $statement->execute
        ([
            'path'=>$photo->getPath(),
            'People_id'=>$photo->getPhotoPeopleId(),
            'id'=>$photo->getPhotoId()
            
        ]);
    }
    public function save(Photo $photo): bool
    {
        if ($people->getPeopleId() === null) {
            return $this->insert($photo);
        }

        return $this->update($photo);
    }
    
    public function remove(Photo $photo):bool
    {
        $sqlRemove = 'DELETE FROM photo WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        return $statement->execute([
            ':id' => $people->getPhotoId()
        ]);
    }
}