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


}