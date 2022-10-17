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

$student = $repository->getStudentByPeopleId($_SESSION['people_id']);

include_once 'elements/head.php';

?>
    
    <h2>Olá, seja bem vindo</h2>
    <!-- começar e preparar esta tela para o estudante (student_panel) -->
    <ul>
        <li><a href="studentProfile.php?id=<?php echo $student->id() ?>">Meu Perfil</a></li>
        <li><a href="">Boletim</a></li>
        <li><a href="">Matérias</a></li>
    </ul>

<?php
    include_once 'elements/footer.php';
    }
?>