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
            <?php $reponsiveBody;?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="row">
                            <div class="card d-inline-flex">
                                <div class="col">
                                    <img class="img-fluid" src="imgs/student-registeruser.svg" alt="student">
                                </div>
                                <button class="btn" onclick="<?php $responsiveBody ="student";?>">
                                    <img class="img-fluid" src="../Pages/imgs/add-icon.svg" alt="add-icon">
                                </button>
                            </div>
                        </div>
                        <?php echo var_dump($responsiveBody == 'student');?>
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