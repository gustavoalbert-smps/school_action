<?php

use Alura\Pdo\Domain\Model\People;
use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
   
    $connection = ConnectDatabase::connect();

    $controller = new PeopleController($connection);

    $peopleRepository = new PdoPeopleRepository($connection);

    $people = $controller->getPeople($peopleRepository, $_POST['id']);

    $controller->updatePeople(
        $peopleRepository,
        $people->getPeopleId(), 
        $_POST['fullName'], 
        $people->getGender(), 
        $people->getBirthDate(), 
        $people->getIsAdmin(),
        $_POST['job'],
        $_POST['phone'], 
        $_POST['email']
    );

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