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

    public function getPhoto(int $id): Photo
    {
        $sqlquery = 'SELECT * FROM photos WHERE id = :id';

        $statement = $this->connection->prepare($sqlquery);

        $statement -> execute
        ([
            ':id' => $id,
        ]);

        $photo = $statement->fetch(PDO::FETCH_ASSOC);

        return new photo ($photo['id'],$photo['path'],$photo['people_id']);
    }
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
    public function resize(Photo $photo)
    {
        $altura = "200";
	    $largura = "200";
        $filename = $people->getPeopleId().'.'.substr($_FILES['fileToUpload']['type'],6);
	// echo "Altura pretendida: $altura - largura pretendida: $largura <br>";
	
	    switch($_FILES['fileToUpload']['type']):
		    case 'image/jpeg';
		    case 'image/pjpeg';

                $imagem_temporaria = imagecreatefromjpeg($_FILES['fileToUpload']['tmp_name']);
                
                $largura_original = imagesx($imagem_temporaria);
                
                $altura_original = imagesy($imagem_temporaria);
                
                echo "largura original: $largura_original - Altura original: $altura_original <br>";
                
                $nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
                
                $nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
                
                $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
                imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
                
                imagejpeg($imagem_redimensionada, 'assets/img/' . $filename);
                
                // echo "<img src='assets/img/".$_FILES['fileToUpdate']['name']."'>";
                
                
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