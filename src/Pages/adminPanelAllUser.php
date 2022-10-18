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
    $connection = ConnectDatabase::connect();

    $userRepository = new PdoUserRepository($connection);
    $peopleRepository = new PdoPeopleRepository($connection);
    $studentRepository = new PdoStudentRepository($connection);
    $eacherRepository = new PdoTeacherRepository($connection);

    $userController = new UserController($connection);

    $people = $userController->Users($peopleRepository);

    $teachers = $userController->totalUsersType('teacher');

    $students = $userController->totalUsersType('');
?>

<?php 
    include_once '../Pages/elements/head.php';
?>
    <div id="table-container">
        <table class="table">
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Genero</th>
            </tr>
        <?php foreach ($people as $people):?>
            <tr>
                <td><a href="/pdo/src/Pages/Profile.php?id=<?= $people['id']?>"><?= $people['name']?></a></td>
                <td><?= $people['birth_date']?></td>
                <td><?= $people['gender']?></td>
            </tr>
    </div>

    <?php endforeach; ?>
<?php
    include_once '../Pages/elements/footer.php';
    }
?>