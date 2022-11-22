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
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="bi bi-calculator-fill me-2"></i>
                                                            Matemática
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="port">
                                            <input id="port" class="form-check-input" type="checkbox" value="português" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-language"></i>
                                                            Português
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        
                                        <label class="form-check-label matter-check text-center shadow" for="geo">
                                            <input id="geo" class="form-check-input" type="checkbox" value="geografia" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-earth-americas"></i>
                                                            Geografia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="hist">
                                            <input id="hist" class="form-check-input" type="checkbox" value="história" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="bi bi-hourglass-split me-2"></i>
                                                            História
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="chem">
                                            <input id="chem" class="form-check-input" type="checkbox" value="química" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-flask-vial"></i>
                                                            Química
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <!-- label.form-check-label.matter-check.text-center.shadow>div.form-body.d-flex.align-items-center>input.form-check-input+span.label.text-break -->
                                    </div>
                                    <div class="form-check matter d-flex flex-wrap justify-content-between">
                                        <label class="form-check-label matter-check text-center shadow" for="phys">
                                            <input id="phys" class="form-check-input" type="checkbox" value="fisíca" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-atom"></i>
                                                            Fisíca
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="bio">
                                            <input id="bio" class="form-check-input" type="checkbox" value="biologia" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-seedling"></i>
                                                            Biologia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="art">
                                            <input id="art" class="form-check-input" type="checkbox" value="artes" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-palette"></i>
                                                            Artes
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="philo">
                                            <input id="philo" class="form-check-input" type="checkbox" value="filosofia" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-brain"></i>
                                                            Filosofia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                        <label class="form-check-label matter-check text-center shadow" for="socio">
                                            <input id="socio" class="form-check-input" type="checkbox" value="sociologia" name="matter">
                                            <span class="label text-break">
                                                <div class="form-body d-flex align-items-center">
                                                    <div class="row d-flex">
                                                        <div class="col">
                                                            <i class="fa-solid fa-scale-balanced"></i>
                                                            Sociologia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $("input:checkbox").on('click', function(){
                    var $box = $(this);

                    if ($box.is(":checked")) {
                        var group = "input:checkbox[name='"+ $box.attr("name")+"']";

                        $(group).prop("checked", false);
                        $box.prop("checked", true);
                    } else {
                        $box.prop("checked", false);
                    }
                });
            </script>
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