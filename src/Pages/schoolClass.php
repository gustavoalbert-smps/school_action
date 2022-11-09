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

    try {
        $class = $classRepository->getClass(intval($_GET['id']));
    } catch (\Throwable $th) {
        header('location: /pdo/src/Pages/elements/pages-error-404.php');
    }
        
    $students = [];
    $students += $studentRepository->getStudentsByClass(intval($_GET['id']));
    require_once '../Pages/elements/head.php';
?>

    <div class="pagetitle">
        <h1>Visualização de Turma</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="schoolClassModule.php">Turmas</a></li>
            <li class="breadcrumb-item active"><?php echo "{$class->getYear()}{$class->getIdentifier()} ";?> <?php echo strtoupper($class->getShift());?></li>
            </ol>
        </nav>
    </div>

    <div id="table-container">   
        <table class="table table-striped students-table">
            <thead>
                <tr class="title">
                    <td class="head" align="center">Nome</td>
                    <td class="head" align="center">Data de Nascimento</td>
                    <td class="head" align="center">Classe Pertencente</td>
                    <?php if ($_SESSION['admin']) {?>
                        <td class="head"></td>
                    <?php }?>
                </tr>
            </thead>
            <?php foreach ($students as $student) { ?>
                <tr>
                    <td class="student-tr name" align="center">
                        <a class="student" href="student.php?id=<?php echo $student->getId()?>"><?php echo $student->getName() ?></a>
                    </td>
                    <td class="student-tr" align="center"><?php echo $student->getBirthDate()->format('d-m-Y') ?></td>
                    <td class="student-tr" align="center"><?php echo $student->getClassId() ?></td>
                    <?php if ($_SESSION['admin']) {?>
                        <td class="student-tr" align="center">
                            <button class="btn" id="x" onclick="window.location.href='removeStudent.php?id=<?php echo $student->getId();?>'">
                                <img class="x-icon" src="../Pages/imgs/x-icon.svg" alt="x-icon">
                            </button>
                        </td>
                    <?php }?>
                </tr>
        <?php } ?>
        </table>
    </div>

    <?php if ($_SESSION['admin']) {?>
        <div class="register-student">
            <a href="registerStudent.php">Cadastrar Aluno</a>
        </div>
    <?php }?>
        
<?php
    require_once '../Pages/elements/footer.php';
    }
?>