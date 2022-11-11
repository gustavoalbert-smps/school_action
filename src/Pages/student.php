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
    try {
        $student = $repository->getStudent(intval($_GET['id']));
    } catch (\Throwable $th) {
        header("location:/pdo/src/Pages/elements/pages-error-404.php");
    }
    

?>

<?php 
    require_once '../Pages/elements/head.php';
?>
        <h1><?php echo $student->getName()?></h1>
        <h4><?php echo $student->getBirthDate()->format('d-m-Y')?></h4>
        <p><?php echo $student->getClassId()?></p>             

<?php 
    require_once '../Pages/elements/footer.php';
    }
?> 