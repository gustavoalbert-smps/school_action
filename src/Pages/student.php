<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();
$repository = new PdoStudentRepository($connection);

$student = $repository->getStudent(intval($_GET['id']));

$user = $_SESSION['user'];
?>

<?php 
    require_once '../Pages/elements/head.php';
?>
        <h1><?php echo $student->getName()?></h1>
        <h4><?php echo $student->getBirthDate()->format('d-m-Y')?></h4>
        <p><?php echo $student->getClassId()?></p>             

<?php 
    require_once '../Pages/elements/footer.php';
?> 