<?php

use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
    if ($_SESSION['admin'] === 1){
        $connection = ConnectDatabase::connect();

        $userRepository = new PdoUserRepository($connection);
        $peopleRepository = new PdoPeopleRepository($connection);
        $studentRepository = new PdoStudentRepository($connection);
        $eacherRepository = new PdoTeacherRepository($connection);

        $userController = new UserController($connection);

        $people = $userController->Users($peopleRepository);

        $teachers = $userController->totalUsersType('teacher');

        $students = $userController->totalUsersType('');
        
        include_once '../Pages/elements/head.php';
?>

        <div id="table-container">
            <table class="table panel-table-striped">
                <thead>
                    <tr class = "title">
                        <td class="head " align="center">Nome</td>
                        <td class="head" align="center">Data de Nascimento</td>
                        <td class="head" align="center">Genero</td>
                    </tr>
                </thead>    
            <?php foreach ($people as $people):?>
                <tr>
                    <td class="admin-tr name" align="center"><a href="/pdo/src/Pages/Profile.php?id=<?= $people['id']?>"><?= $people['name']?></a></td>
                    <td class="" align="center"><?= $people['birth_date']?></td>
                    <td class="" align="center"><?= $people['gender']?></td>
                </tr>
        </div>

<?php 
        endforeach;

        include_once '../Pages/elements/footer.php';
        } else {
            if ($_SESSION['teacher'] === 0) {
              header('Location: /pdo/src/Pages/studentsModule.php');
            } else {
              header('Location: /pdo/src/Pages/schoolClassModule.php');
            }
        }
    }
?>