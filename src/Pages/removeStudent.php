<?php 

use Alura\Pdo\Domain\Model\Student;
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student = $repository->getStudent(intval($_POST['id']));
        $repository->remove($student);
        header('Location: studentsModule.php');
    } else {
        $student = $repository->getStudent(intval($_GET['id']));
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
    }
?>