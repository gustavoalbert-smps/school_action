<?php

use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Controller\SchoolClassController;
use Alura\Pdo\Infrastructure\Controller\TeacherController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
    $connection = ConnectDatabase::connect();

    $peopleRepository = new PdoPeopleRepository($connection);
    $peopleController = new PeopleController($connection);

    $people = $peopleController->getPeople($peopleRepository, $_SESSION['people_id']);

    $teacherRepository = new PdoTeacherRepository($connection);
    $teacherController = new TeacherController($connection);

    $teacher = $teacherController->getTeacherWithPeopleId($teacherRepository, $people->getPeopleId());

    $innerJoin = $teacherController->teacherClasses($teacherRepository, $teacher->getId());

    $schoolClassRepository = new PdoSchoolClassRepository($connection);
    $schoolClassController = new SchoolClassController($connection);

    $classes = $schoolClassController->findingClasses($schoolClassRepository, $innerJoin);

    require_once 'elements/head.php';
?>

    <?php foreach ($classes as $class):?>
        <div class="card class-card">
            <div class="card-body">
                <h5 class="card-title">TURMA <?php echo "{$class->getYear()}{$class->getIdentifier()}";?></h5>
                <h6 class="card-subtitle"><?php echo $class->getShift();?></h6>
            </div>
        </div>
    <?php endforeach;?>

<?php
    require_once 'elements/footer.php';
}
?>