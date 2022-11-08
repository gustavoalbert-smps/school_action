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
        $reponsiveBody;
?>

        <body>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="row">
                            <div class="col">
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
                                                <a id="add-link" href="#"><img id="add-icon" class="img-fluid" src="imgs/add-icon.svg" alt="add-icon"></a>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                <a id="add-link" href="#"><img id="add-icon" class="img-fluid" src="imgs/add-icon.svg" alt="add-icon"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo var_dump($responsiveBody === 'student');?>
                        <?php if ($responsiveBody == "student") {
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