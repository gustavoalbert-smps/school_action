<?php

use Alura\Pdo\Infrastructure\Controller\SchoolClassController;
use Alura\Pdo\Infrastructure\Controller\StudentController;
use Alura\Pdo\Infrastructure\Controller\TeacherController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {

    if($_SESSION['admin'] == true)
    {
        header('location: /pdo/src/Pages/adminSchoolClassModule.php');
    }

    $connection = ConnectDatabase::connect();

    $teacherRepository = new PdoTeacherRepository($connection);
    $teacherController = new TeacherController($connection);

    $teacher = $teacherController->getTeacherWithPeopleId($teacherRepository, $_SESSION['people_id']);

    $innerJoin = $teacherController->teacherClasses($teacherRepository, $teacher->getId());

    $schoolClassRepository = new PdoSchoolClassRepository($connection);
    $schoolClassController = new SchoolClassController($connection);

    $classes = $schoolClassController->findingClasses($schoolClassRepository, $innerJoin);

    $studentRepository = new PdoStudentRepository($connection);
    $studentController = new StudentController($connection);

    require_once 'elements/head.php';
?>

    <?php foreach ($classes as $class):?>
        <div class="card class-card">
            <div class="card-body">
                <h5 class="card-title class-identifier">TURMA <?php echo "{$class->getYear()}{$class->getIdentifier()}";?></h5>
                <div class="class-text">
                    <p class="card-text class-shift">
                        <?php 
                        if ($class->getShift() === 'manha'){
                            $shift = 'MANHÃ';
                        } else {
                            $shift = 'TARDE';
                        }
                        echo $shift;
                        ?>
                    </p>
                    <p class="card-text class-students">
                        <?php echo $studentController->numberOfStudentsByClass($studentRepository, $class->getId());?> ESTUDANTES
                    </p>
                </div>
                <a href="schoolClass.php?id=<?php echo $class->getId();?>" class="stretched-link"></a>
            </div>
        </div>
    <?php endforeach;?>

<?php
    require_once 'elements/footer.php';
}
?>