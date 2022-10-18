<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {

    $connection = ConnectDatabase::connect();

    $classRepository = new PdoSchoolClassRepository($connection);

    $studentRepository = new PdoStudentRepository($connection);

    $class = $classRepository->getClass(intval($_GET['id']));

    $students = [];
    $students += $studentRepository->getStudentsByClass(intval($_GET['id']));

?>

<?php
    require_once '../Pages/elements/head.php';
?>

<h3>TURMA: <?php echo "{$class->getYear()}{$class->getIdentifier()} ";?> TURNO: <?php echo strtoupper($class->getShift());?></h1>

<div id="table-container">   
    <table class="table table-striped students-table">
        <thead>
            <tr class="title">
                <td class="head" align="center">Nome</td>
                <td class="head" align="center">Data de Nascimento</td>
                <td class="head" align="center">Classe Pertencente</td>
                <td class="head"></td>
            </tr>
        </thead>
        <?php foreach ($students as $student) { ?>
            <tr>
                <td class="student-tr name" align="center">
                    <a class="student" href="student.php?id=<?php echo $student->id()?>"><?php echo $student->getName() ?></a>
                </td>
                <td class="student-tr" align="center"><?php echo $student->getBirthDate()->format('d-m-Y') ?></td>
                <td class="student-tr" align="center"><?php echo $student->getClassId() ?></td>
                <td class="student-tr" align="center">
                    <button class="btn" id="x" onclick="window.location.href='/student/removeStudent.php?id=<?php echo $student->id()?>'">
                        <img class="x-icon" src="../Pages/imgs/x-icon.svg" alt="x-icon">
                    </button>
                </td>
            </tr>
    <?php } ?>
    </table>
</div>

<a href="registerStudent.php">Cadastrar Aluno</a>
        
<?php
    require_once '../Pages/elements/footer.php';
    }
?>