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

        $varGraduation = $_COOKIE["graduation"];

        if (isset($varGraduation)) {
            echo 'deu erro';
        } else {
            if ($varGraduation === "") {
                $teachers = $teacherController->getAllTeachers($teacherRepository);
            } else {
                $teachers = $teacherController->getTeachersWithSpecificGraduation($teacherRepository,$varGraduation);
            }
        }
        

        $classes = $schoolClassController->getAllClass($schoolClassRepository);

        include_once 'elements/head.php';
?>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="bg-white rounded-lg shadow-sm p-5">
                            <form class="form" action="adminMatters.php" method="POST">
                                <div class="mb-3 checkoption-matter">
                                    <p class="input-title">Matérias</p>
                                    <div class="form-check matter d-flex flex-wrap justify-content-between">
                                        <label class="form-check-label matter-check text-center shadow" for="math">
                                            <input type="checkbox" id="math" class="form-check-input" value="matemática" name="matter[1][]" >
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
                                            <input id="port" class="form-check-input" type="checkbox" value="português" name="matter[1][]">
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
                                            <input id="geo" class="form-check-input" type="checkbox" value="geografia" name="matter[1][]">
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
                                            <input id="hist" class="form-check-input" type="checkbox" value="história" name="matter[1][]">
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
                                            <input id="chem" class="form-check-input" type="checkbox" value="química" name="matter[1][]">
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
                                            <input id="phys" class="form-check-input" type="checkbox" value="fisíca" name="matter[1][]">
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
                                            <input id="bio" class="form-check-input" type="checkbox" value="biologia" name="matter[1][]">
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
                                            <input id="art" class="form-check-input" type="checkbox" value="artes" name="matter[1][]">
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
                                            <input id="philo" class="form-check-input" type="checkbox" value="filosofia" name="matter[1][]">
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
                                            <input id="socio" class="form-check-input" type="checkbox" value="sociologia" name="matter[1][]">
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
                                <div class="mb-3">
                                    <div class="row justify-content-between">
                                        <div class="col select-form">
                                            <label for="workload" class="form-label workload-label input-title">Carga horária</label>
                                            <select id="workload" class="form-select" name="workload">
                                                    <option value="default" selected>Selecione uma opção...</option>
                                                    <option value="40">40 horas</option>
                                                    <option value="60">60 horas</option>
                                                    <option value="80">80 horas</option>
                                                    <option value="100">100 horas</option>
                                                    <option value="120">120 horas</option>
                                            </select>
                                        </div>
                                        <div class="col select-form">
                                            <label for="class" class="form-label input-title">Turma</label>
                                            <select id="class" class="form-select" name="class">
                                                <option value="default" selected>Selecione uma opção...</option>
                                                <?php foreach ($classes as $class) {?>
                                                    <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col select-form">
                                            <label for="teacher" class="form-label input-title">Professor</label>
                                            <select id="teacher" class="form-select" name="teacher">
                                                <option value="default" selected>Selecione uma opção...</option>
                                                <?php foreach ($teachers as $teacher) {?>
                                                    <option value="<?php echo $teacher->getId();?>"><?php echo $teacher->getPeopleId();?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.cookie ='graduation=""';

                $("input:checkbox").on('click', function(){
                    
                    if ($(this).is(":checked")) {
                        var group = "input:checkbox[name='"+ $(this).attr("name")+"']";

                        var graduation = $(this).val();
                        document.cookie = 'graduation=' + graduation;
                        
                        $(group).prop("checked", false);
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
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