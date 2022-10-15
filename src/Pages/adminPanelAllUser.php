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
<div id="table-container">
    <table>
        <tr>
            <td>Nome</td>
            <td>Data de Nascimento</td>
            <td>Genero</td>
        </tr>
    <?php foreach ($people as $people):?>
        <tr>
            <td><?= $people['name']?></td>
            <td><?= $people['birth_date']?></td>
            <td><?= $people['gender']?></td>
        </tr>

    <?php endforeach; ?>
<?php
    include_once '../Pages/elements/footer.php';
?>