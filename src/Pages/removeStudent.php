<?php

use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Controller\StudentController;
use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: index.php');
} else {
    if ($_SESSION['admin']){
        $connection = ConnectDatabase::connect();

        $studentRepository = new PdoStudentRepository($connection);
        $studentController = new StudentController($connection);

        $userRepository = new PdoUserRepository($connection);
        $userController = new UserController($connection);

        $peopleRepository = new PdoPeopleRepository($connection);
        $peopleController = new PeopleController($connection);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student = $studentController->getStudent($studentRepository, intval($_POST['id']));
            
            $user = $userController->getUserWithPeopleId($userRepository, $student->getPeopleId());

            $people = $peopleController->getPeople($peopleRepository, $student->getPeopleId());

            if ($studentController->removeStudent($studentRepository, $student) && 
                $userController->removeUser($userRepository, $user) && 
                $peopleController->removePeople($peopleRepository, $people)){
                header('Location: studentsModule.php');
            } else {
                echo 'erro';
            }
        } else {
            $student = $studentController->getStudent($studentRepository, intval($_GET['id']));
        }

        include_once '../Pages/elements/head.php';
?>


        <div class="container">
            <h1><?php echo $student->getName()?></h1>
            <h4><?php echo $student->getBirthDate()->format('d-m-Y')?></h4>
            <p><?php echo $student->getClassId()?></p>
        </div>
        <div id="confirmation-box">
            <form action="removeStudent.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <button class="btn">Confirmar</button>
            </form>
            <button class="btn" onclick="window.location.href = 'studentsModule.php'">Cancelar</button>
        </div>

<?php
    include_once '../Pages/elements/footer.php';
    } else {
        header('Location: schoolClassModule.php');
    }
}
?>