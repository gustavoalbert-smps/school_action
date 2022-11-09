<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
    if ($_SESSION['admin']){

        $connection = ConnectDatabase::connect();

        include_once 'elements/head.php';
?>

        <body>
            <?php $reponsiveBody = '';?>
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php echo var_dump($reponsiveBody === 'student');?>
                        <?php if ($reponsiveBody == "student") {
                            include_once 'elements/studentRegisterForm.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </body>

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