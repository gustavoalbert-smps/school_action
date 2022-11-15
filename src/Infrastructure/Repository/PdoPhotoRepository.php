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
    public function countPhoto(int $id): int
    {
        $sqlquery = 'SELECT count(id) FROM photos WHERE people_id = :id';

        $statement = $this->connection->prepare($sqlquery);

        $statement->execute([
            ':id' => $id
        ]);

        $photo = $statement->fetch(PDO::FETCH_ASSOC);

        $photo = $photo['count(id)'];

        return $photo;

    }
    public function getPhoto(int $people_id): Photo
    {
        $sqlquery = 'SELECT * FROM photos WHERE people_id = :people_id';

        $statement = $this->connection->prepare($sqlquery);

        $statement->execute([
            ':people_id' => $people_id
        ]);

        $photo = $statement->fetch(PDO::FETCH_ASSOC);

        return $Photo = new Photo ($photo['id'],$photo['people_id'],$photo['name'],$photo['type']); 

    }    
    public function insert(int $people_id, Array $file): bool
    {
        $name = $_POST['id'].'-'.date("Y-m-d").time().'.'.substr($file['img']['type'],6);

        $sqlInsert = 'INSERT photos (people_id,name,type) VALUE (:people_id,:name,:type)';

        $statement = $this->connection->prepare($sqlInsert);

        $height = "200";
        $width = "200";
        $filename = $name;
    
        switch($file['img']['type']):
            case 'image/jpeg';
            case 'image/pjpeg';

           

                $tmp_img = imagecreatefromjpeg($file['img']['tmp_name']);
    
                $original_width = imagesx($tmp_img);
    
                $original_height = imagesy($tmp_img);
    
                $new_height = $width ? $width : floor (($original_width / $original_height) * $height);
    
                $new_width = $height ? $height : floor (($original_height / $original_width) * $width);
    
                $img_resize = imagecreatetruecolor($new_height, $new_width);
                imagecopyresampled($img_resize, $tmp_img, 0, 0, 0, 0, $new_height, $new_width, $original_width, $original_height);
    
                imagejpeg($img_resize, 'assets/img/' . $filename);
    
            break;
            case 'image/png':
            case 'image/x-png';
                
                
                
                $tmp_img = imagecreatefrompng ($file['img']['tmp_name']);
    
                $original_width = imagesx($tmp_img);
                $original_height = imagesy($tmp_img);
             
                $new_width = $width ? $width : floor(( $original_width / $original_height ) * $height);
    
                $new_height = $height ? $height : floor(( $original_height / $original_width ) * $width);
    
                $img_resize = imagecreatetruecolor($new_height, $new_width);
    
                    /* Copia a nova imagem da imagem antiga com o tamanho correto */
                // imagealphablending($img_resize, false);
                // imagesavealpha($img_resize, true);
    
                imagecopyresampled($img_resize, $tmp_img, 0, 0, 0, 0, $new_height, $new_width, $original_width, $original_height);
    
                    //função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
                imagepng($img_resize, 'assets/img/'.$filename);
            break;

            case 'image/webp':
                    
                    $tmp_img = imagecreatefromwebp ($file['img']['tmp_name']);
        
                    $original_width = imagesx($tmp_img);
                    $original_height = imagesy($tmp_img);
                 
                    $new_width = $width ? $width : floor(( $original_width / $original_height ) * $height);
        
                    $new_height = $height ? $height : floor(( $original_height / $original_width ) * $width);
        
                    $img_resize = imagecreatetruecolor($new_height, $new_width);
        
                        /* Copia a nova imagem da imagem antiga com o tamanho correto */
                    // imagealphablending($img_resize, false);
                    // imagesavealpha($img_resize, true);
        
                    imagecopyresampled($img_resize, $tmp_img, 0, 0, 0, 0, $new_height, $new_width, $original_width, $original_height);
        
                        //função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
                    imagepng($img_resize, 'assets/img/'.$filename);
                break;
        endswitch; 

        return  $statement-> execute
        ([
            ':people_id'=> $people_id,
            ':name' => $name,
            ':type'=>substr($file['img']['type'],6)
        ]);
        
        // return resize($file,$name);
    }
    public function update (Photo $photo): bool
    {
        $sqlUpdate = 'UPDATE photos SET path = :path, people_id = :people_id WHERE id = :id';

        $statement = $this->connection->prepare($sqlUpdate);

        $statement->execute
        ([
            'path'=>$photo->getPath(),
            'People_id'=>$photo->getPeople_id(),
            'id'=>$photo->getId()
            
        ]);
        
    }
    public function save(Photo $photo): bool
    {
        if ($photo->getPeople_id() === null) {
            return $this->insert($photo);
        }

        return $this->update($photo);
    }
    
    public function remove(Photo $photo):bool
    {
        var_dump($photo->getId());
        
        $sqlRemove = 'DELETE FROM photos WHERE id = :id'; 

        $statement = $this->connection->prepare($sqlRemove);

        return $statement->execute([
            ':id' => $photo->getId()
        ]);
    }
}
