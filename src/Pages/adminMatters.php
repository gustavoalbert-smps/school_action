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
                                            <div class="form-body d-flex align-items-center">
                                                <input id="math" class="form-check-input" type="checkbox" value="matemática" name="matter" >
                                                <span class="label text-break"><i class="bi bi-calculator-fill me-2"></i>Matemática</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="port">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="port" class="form-check-input" type="checkbox" value="português" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-language"></i>Português</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="geo">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="geo" class="form-check-input" type="checkbox" value="geografia" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-earth-americas"></i>Geografia</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="hist">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="hist" class="form-check-input" type="checkbox" value="história" name="matter">
                                                <span class="label text-break"><i class="bi bi-hourglass-split me-2"></i>História</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="chem">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="chem" class="form-check-input" type="checkbox" value="química" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-flask-vial"></i>Química</span>
                                            </div>
                                        </label>
                                        <!-- label.form-check-label.matter-check.text-center.shadow>div.form-body.d-flex.align-items-center>input.form-check-input+span.label.text-break -->
                                    </div>
                                    <div class="form-check matter d-flex flex-wrap justify-content-between">
                                        <label class="form-check-label matter-check text-center shadow" for="phys">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="phys" class="form-check-input" type="checkbox" value="fisíca" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-atom"></i>Fisíca</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="bio">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="bio" class="form-check-input" type="checkbox" value="biologia" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-seedling"></i>Biologia</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="art">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="art" class="form-check-input" type="checkbox" value="artes" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-palette"></i>Artes</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="philo">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="philo" class="form-check-input" type="checkbox" value="filosofia" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-brain"></i>Filosofia</span>
                                            </div>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="socio">
                                            <div class="form-body d-flex align-items-center">
                                                <input id="socio" class="form-check-input" type="checkbox" value="sociologia" name="matter">
                                                <span class="label text-break"><i class="fa-solid fa-scale-balanced"></i>Sociologia</span>
                                            </div>
                                        </label>
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