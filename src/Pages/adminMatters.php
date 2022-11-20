<?php

use Alura\Pdo\Infrastructure\Controller\MatterController;
use Alura\Pdo\Infrastructure\Controller\SchoolClassController;
use Alura\Pdo\Infrastructure\Controller\TeacherController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoMatterRepository;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
    if ($_SESSION['admin']){
        $connection = ConnectDatabase::connect();

        $teacherController = new TeacherController($connection);
        $teacherRepository = new PdoTeacherRepository($connection);

        $schoolClassController = new SchoolClassController($connection);
        $schoolClassRepository = new PdoSchoolClassRepository($connection);

        $matterController = new MatterController($connection);
        $matterRepository = new PdoMatterRepository($connection);

        $teachers = $teacherController->getAllTeachers($teacherRepository);

        include_once 'elements/head.php';
?>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="bg-white rounded-lg shadow-sm p-5">
                            <form class="form" action="adminMatters.php" method="POST">
                                <div class="mb-3 checkoption-matter">
                                    <p>Matérias</p>
                                    <div class="form-check matter d-flex flex-wrap justify-content-between">
                                        <label class="form-check-label matter-check text-center shadow" for="math">
                                            <input id="math" class="form-check-input" type="checkbox" value="matemática" name="matter" >
                                            <span class="label text-break"><i class="bi bi-calculator-fill me-2"></i>Matemática</span>
                                        </label>
                                        <label for="port" class="form-check-label matter-check text-center shadow">
                                            <input id="port" class="form-check-input" type="checkbox" value="português" name="matter" >
                                            <span class="label text-break"><i class="fa-solid fa-language"></i>Português</span>
                                        </label>
                                        <label for="geo" class="form-check-label matter-check text-center shadow">
                                            <input id="geo" class="form-check-input" type="checkbox" value="geografia" name="matter">
                                            <span class="label text-break">Geografia</span>
                                        </label>
                                        <label for="hist" class="form-check-label matter-check text-center shadow">
                                            <input id="hist" class="form-check-input" type="checkbox" value="história" name="matter">
                                            <span class="label text-break">História</span>
                                        </label>
                                        <label for="chem" class="form-check-label matter-check text-center shadow">
                                            <input id="chem" class="form-check-input" type="checkbox" value="química" name="matter">
                                            <span class="label text-break">Química</span>
                                        </label>
                                        <!-- label.form-check-label.matter-check.text-center.shadow-sm>input.form-check-input+span.label -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </body>

<?php
    } else {
        if ($_SESSION['teacher']) {
            header('Location: schoolClassModule.php');
        } else {
            header('Location: studentsModule.php');
        }
    }
}
?>