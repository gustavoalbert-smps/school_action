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
            ':id' => $people_id
        ]);

        $photo = $statement->fetch(PDO::FETCH_ASSOC);

        print_r($people_id);
      
        return $Photo = new Photo ($photo['id'],$photo['people_id'],$photo['name'],$photo['type']); 

    }    
    public function insert(int $people_id, Array $file): bool
    {
        $name = $_POST['id'].'-'.date("Y-m-d").time().'.'.substr($file['img']['type'],6);

        $sqlInsert = 'INSERT photos (people_id,name,type) VALUE (:people_id,:name,:type)';

        $statement = $this->connection->prepare($sqlInsert);

        $statement-> execute
        ([
            ':people_id'=> $people_id,
            ':name' => $name,
            ':type'=>substr($file['img']['type'],6)
        ]);

        return move_uploaded_file($file['img']['tmp_name'], 'assets/img/'.$name);
    }
    public function update (Photo $photo): bool
    {
        $sqlUpdate = 'UPDATE photos SET path = :path, people_id = :people_id WHERE id = :id';

        $statement = $this->connection->prepare($sqlUpdate);

        return $statement->execute
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
        $sqlRemove = 'DELETE FROM photo WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        return $statement->execute([
            ':id' => $photo->getId()
        ]);
    }

    public function resize(Photo $photo, int $altura, int $largura)
    {
        // $altura = "200";
	    // $largura = "200";
        $filename = $photo->getName().$altura.$largura;
	// echo "Altura pretendida: $altura - largura pretendida: $largura <br>";
        $filename = "teste.jpeg";

        echo $photo->getType();

	    switch($photo->getType()):
		    case 'jpeg';
		    case 'pjpeg';
               $imagem_temporaria = imagecreatefromjpeg($photo->getName());
                // $_FILES['fileToUpload']['tmp_name']
                
                $largura_original = imagesx($imagem_temporaria);
                
                $altura_original = imagesy($imagem_temporaria);
                
                echo "largura original: $largura_original - Altura original: $altura_original <br>";
                
                $nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
                
                $nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
                
                $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
                
                imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
                
                return imagejpeg($imagem_redimensionada, 'assets/img/' . $filename);
            break;
		
		//Caso a imagem seja extensão PNG cai nesse CASE
            case 'image/png':
            case 'image/x-png';
            
                $imagem_temporaria = imagecreatefrompng ($_FILES['fileToUpload']['tmp_name']);
                
                $largura_original = imagesx($imagem_temporaria);
                $altura_original = imagesy($imagem_temporaria);
                // 	// echo "Largura original: $largura_original - Altura original: $altura_original <br> ";
                    
                // 	/* Configura a nova largura */
                $nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

                    /* Configura a nova altura */
                $nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
                    
                    /* Retorna a nova imagem criada */
                $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
                    
                    /* Copia a nova imagem da imagem antiga com o tamanho correto */
                // imagealphablending($imagem_redimensionada, false);
                // imagesavealpha($imagem_redimensionada, true);

                imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
                    
                    //função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
                imagepng($imagem_redimensionada, 'assets/img/'.$filename);
                    
                // echo "<img src='assets/img/" .$imgUpload. "'>";
		    break;
	    endswitch;  
    }
}
