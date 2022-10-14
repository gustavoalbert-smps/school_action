<?php

use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once '../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();

$userRepository = new PdoUserRepository($connection);
$peopleRepository = new PdoPeopleRepository($connection);
$studentRepository = new PdoStudentRepository($connection);
$eacherRepository = new PdoTeacherRepository($connection);

$userController = new UserController($connection);

$people = $userController->Users($peopleRepository);

$teachers = $userController->totalUsersType('teacher');

$students = $userController->totalUsersType('');

$user = $_SESSION['user'];

?>

<?php 
    include_once '../Pages/elements/head.php';
?>

<?php
    include_once '../Pages/elements/footer.php';
?>