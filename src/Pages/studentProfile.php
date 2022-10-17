<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {

$connection = ConnectDatabase::connect();
$repository = new PdoStudentRepository($connection);

$student = $repository->getStudent(intval($_GET['id']));

?>

<?php
    require_once '../Pages/elements/head.php';
?>

    <nav class="navbar navbar-dark bg-dark p-0">
        <!-- Navbar content -->
        <ul class="nav justify-content-center m-0">
            <li class="nav-item">
                <div class="d-flex justify-content-center">
                    <?php include '../Pages/elements/studentModule-redirect.html';?>
                </div>
            </li>
        </ul>
    </nav>
    
    <div class="container" style="height: 100%;">
        <section class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        
                        <h1><?php echo $student->getName()?></h1>
                        <h4><?php echo $student->getBirthDate()->format('d-m-Y')?></h4>
                        <p><?php echo $student->getClassId()?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>


<?php
    require_once 'elements/footer.php';
    }
?>