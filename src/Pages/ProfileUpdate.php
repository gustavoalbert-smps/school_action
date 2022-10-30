<?php

use Alura\Pdo\Domain\Model\People;
use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Controller\PhotoController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPhotoRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
   
    $connection = ConnectDatabase::connect();

    $controller = new PeopleController($connection);

    $peopleRepository = new PdoPeopleRepository($connection);

    $photoRepository = new PdoPhotoRepository($connection);

    $photoController = new photoController($connection);


    if($_FILES['img']['size'] !== 0)
    {
        $people_id = $_POST['id'];

        $photoController->insertPhoto($photoRepository,$people_id,$_FILES);

        $photo = $photoController->Photo($photoRepository,$people_id);

        $photoController->size($photo,200,200);

        header('Location: /pdo/src/Pages/Profile.php?id='.$people_id);
    }
    else
    {

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

    }


}