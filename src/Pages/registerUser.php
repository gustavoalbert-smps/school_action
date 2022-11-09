<?php

use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Controller\StudentController;
use Alura\Pdo\Infrastructure\Controller\TeacherController;
use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
    if ($_SESSION['admin']){

        $connection = ConnectDatabase::connect();

        $peopleRepository = new PdoPeopleRepository($connection);
        $peopleController = new PeopleController($connection);

        $userRepository = new PdoUserRepository($connection);
        $userController = new UserController($connection);

        $teacherRepository = new PdoTeacherRepository($connection);
        $teacherController = new TeacherController($connection);

        $studentRepository = new PdoStudentRepository($connection);
        $studentController = new StudentController($connection);

        $classRepository = new PdoSchoolClassRepository($connection);

        $classes = $classRepository->allClasses();

        include_once 'elements/head.php';

        $reponsiveBody = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['recording-user'])) {
                if ($_POST['form-type'] === 'student') {
                    $peopleController->insertPeople($peopleRepository, $_POST['name'], $_POST['gender'], $_POST['birth_date'], 0);
            
                    $id = intval($connection->lastInsertId());

                    $bdPeople = $peopleController->getPeople($peopleRepository, $id);

                    $userController->insertUser($userRepository, $_POST['user'], $_POST['password'], 0, $bdPeople->getPeopleId(), $_POST['name'], $_POST['gender'], $_POST['birth_date'], 0);

                    try {
                        $studentController->insertStudent(
                            $studentRepository, 
                            $bdPeople->getPeopleId(), 
                            $_POST['name'], 
                            $_POST['gender'], 
                            $_POST['birth_date'], 
                            $_POST['class'], 
                            0
                        );
                    } catch (\Throwable $th) {
                        echo 'algo de errado no seu cadastro';
                    }

                } elseif ($_POST['form-type'] === 'teacher') {
                    $peopleController->insertPeople($peopleRepository, $_POST['name'], $_POST['gender'], $_POST['birth_date'], 0);
            
                    $id = intval($connection->lastInsertId());

                    $bdPeople = $peopleController->getPeople($peopleRepository, $id);

                    $userController->insertUser($userRepository, $_POST['user'], $_POST['password'], 0, $bdPeople->getPeopleId(), $_POST['name'], $_POST['gender'], $_POST['birth_date'], 0);

                    try {
                        $teacherController->insertTeacher(
                            $teacherRepository, 
                            $bdPeople->getPeopleId(), 
                            $_POST['graduation'], 
                            $_POST['name'], 
                            $_POST['gender'], 
                            $_POST['birth_date'], 
                            0
                        );
                    } catch (\Throwable $th) {
                        echo 'algo de errado no seu cadastro';
                    }
                }
                header('Location: registerUser.php');
            }
            if ($_POST['student'] === 'student') {
                $reponsiveBody = 'student';
                
                include_once 'elements/head.php';
?>
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 mx-auto">
                                <div class="row">
                                    <div class="col">
                                        <form class="register-user-form" action="registerUser.php" method="POST">
                                            <div class="card">
                                                <div class="card-body register-card">
                                                    <h4 class="card-title">
                                                        Cadastrar Estudante
                                                    </h4>
                                                    <div class="row align-items-end">
                                                        <div class="col student-img">
                                                            <img id="student-register" class="img-fluid" src="imgs/student-registeruser.svg" alt="student-register-icon">
                                                        </div>
                                                        <div class="col add-card">
                                                            <input class="btn img-fluid" id="add-student" type="submit" placeholder="" name="add-student" value="">
                                                            <input type="hidden" id="student" name="student" value="student">
                                                            <input type="hidden" id="teacher" name="teacher" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form class="register-user-form" action="registerUser.php" method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body register-card">
                                                            <h4 class="card-title">
                                                                Cadastrar Professor
                                                            </h4>
                                                            <div class="row align-items-end">
                                                                <div class="col">
                                                                    <img id="teacher-register" class="img-fluid" src="imgs/teacher-icon.svg" alt="teacher-register-icon">
                                                                </div>
                                                                <div class="col add-card">
                                                                    <input class="btn img-fluid" id="add-teacher" type="submit" name="add-teacher" value="">
                                                                    <input type="hidden" id="teacher" name="teacher" value="teacher">
                                                                    <input type="hidden" id="student" name="student" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php if ($reponsiveBody == "student") {
                                    include_once 'studentRegisterForm.php';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </body>

<?php
                include_once 'elements/footer.php';
            } elseif ($_POST['teacher'] === 'teacher') {
                $reponsiveBody = 'teacher';

                include_once 'elements/head.php';
?>
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 mx-auto">
                                <div class="row">
                                    <div class="col">
                                        <form class="register-user-form" action="registerUser.php" method="POST">
                                            <div class="card">
                                                <div class="card-body register-card">
                                                    <h4 class="card-title">
                                                        Cadastrar Estudante
                                                    </h4>
                                                    <div class="row align-items-end">
                                                        <div class="col student-img">
                                                            <img id="student-register" class="img-fluid" src="imgs/student-registeruser.svg" alt="student-register-icon">
                                                        </div>
                                                        <div class="col add-card">
                                                            <input class="btn img-fluid" id="add-student" type="submit" placeholder="" name="add-student" value="">
                                                            <input type="hidden" id="student" name="student" value="student">
                                                            <input type="hidden" id="teacher" name="teacher" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form class="register-user-form" action="registerUser.php" method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body register-card">
                                                            <h4 class="card-title">
                                                                Cadastrar Professor
                                                            </h4>
                                                            <div class="row align-items-end">
                                                                <div class="col">
                                                                    <img id="teacher-register" class="img-fluid" src="imgs/teacher-icon.svg" alt="teacher-register-icon">
                                                                </div>
                                                                <div class="col add-card">
                                                                    <input class="btn img-fluid" id="add-teacher" type="submit" name="add-teacher" value="">
                                                                    <input type="hidden" id="teacher" name="teacher" value="teacher">
                                                                    <input type="hidden" id="student" name="student" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php if ($reponsiveBody == "teacher") {
                                    include_once 'teacherRegisterForm.php';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </body>
                
<?php
            }
        } else {
?>
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col">
                                    <form class="register-user-form" action="registerUser.php" method="POST">
                                        <div class="card">
                                            <div class="card-body register-card">
                                                <h4 class="card-title">
                                                    Cadastrar Estudante
                                                </h4>
                                                <div class="row align-items-end">
                                                    <div class="col student-img">
                                                        <img id="student-register" class="img-fluid" src="imgs/student-registeruser.svg" alt="student-register-icon">
                                                    </div>
                                                    <div class="col add-card">
                                                        <input class="btn img-fluid" id="add-student" type="submit" placeholder="" name="add-student" value="">
                                                        <input type="hidden" id="student" name="student" value="student">
                                                        <input type="hidden" id="teacher" name="teacher" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col">
                                    <form class="register-user-form" action="registerUser.php" method="POST">
                                        <div class="row">
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-body register-card">
                                                        <h4 class="card-title">
                                                            Cadastrar Professor
                                                        </h4>
                                                        <div class="row align-items-end">
                                                            <div class="col">
                                                                <img id="teacher-register" class="img-fluid" src="imgs/teacher-icon.svg" alt="teacher-register-icon">
                                                            </div>
                                                            <div class="col add-card">
                                                                <input class="btn img-fluid" id="add-teacher" type="submit" name="add-teacher" value="">
                                                                <input type="hidden" id="teacher" name="teacher" value="teacher">
                                                                <input type="hidden" id="student" name="student" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
<?php
        }
?>

<?php
        include_once 'elements/footer.php';
    } else {
        if ($_SESSION['teacher']) {
            header('Location: schoolClassModule.php');
        } else {
            header('Location: studentsModule.php');
        }
    }
}
?>