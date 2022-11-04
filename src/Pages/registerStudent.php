<?php
use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Controller\StudentController;
use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
    $_SESSION = array();
    header('Location: /pdo/src/Pages/index.php');
} else {
    if ($_SESSION['admin']){
        $connection = ConnectDatabase::connect();

        $classRepository = new PdoSchoolClassRepository($connection);
        
        $peopleRepository = new PdoPeopleRepository($connection);
        $peopleController = new PeopleController($connection);

        $userRepository = new PdoUserRepository($connection);
        $userController = new UserController($connection);

        $studentRepository = new PdoStudentRepository($connection);
        $studentController = new StudentController($connection);

        $classes = $classRepository->allClasses();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $peopleController->insertPeople($peopleRepository, $_POST['name'], $_POST['gender'], $_POST['birth_date'], 0);
            
            $id = intval($connection->lastInsertId());

            $bdPeople = $peopleController->getPeople($peopleRepository, $id);

            $userController->insertUser($userRepository, $_POST['user'], $_POST['password'], 0, $bdPeople->getPeopleId(), $_POST['name'], $_POST['gender'], $_POST['birth_date'], 0);

            $studentController->insertStudent($studentRepository, $bdPeople->getPeopleId(), $_POST['name'], $_POST['gender'], $_POST['birth_date'], $_POST['class'], 0);

            header('Location: registerStudent.php');
        }

        require_once '../Pages/elements/head.php';
?>
        <div class="pagetitle">
        <h1>Cadastrar novo aluno</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="adminPanel.php">Painel do Administrador</a></li>
                <li class="breadcrumb-item active">Cadastrar Aluno</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped bg-primary active" role="progressbar"></div>
                    </div>
                    <form class="form" id="registration-form" action="registerStudent.php" method="POST">
                        <fieldset>
                            <div class="form-floating mb-3">
                                <label for="user">Nome de usuário</label>
                                <input class="form-control" type="text" name="user" id="user">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="password">Senha</label>
                                <input class="form-control" type="text" name="password" id="password">
                            </div>
                            <input type="button" name="next" class="next btn btn-primary mb-3" value="Próximo">
                        </fieldset>
                        <fieldset>
                            <div class="form-floating mb-3">
                                <label for="name">Nome</label>
                                <input class="form-control" type="text" name="name" id="name">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="birth_date">Data de Nascimento</label>
                                <input class="form-control" type="text" placeholder="Data de Nascimento" onfocus="this.type='date';" onblur="this.type='text';" name="birth_date" id="birth-date">
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="masc" name="gender" value="masculino">
                                <label class="form-check-label" for="masc">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="fem" name="gender" value="masculino">
                                <label class="form-check-label" for="fem">Feminino</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="outros" name="gender" value="outros">
                                <label class="form-check-label" for="outros">Outros</label>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="class">Classe pertencente</label>
                                <select class="form-select" name="class" id="class">
                                    <?php foreach ($classes as $class) {?>
                                        <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="button" name="previous" class="previous btn btn-secondary" value="Voltar">
                            <input type="submit" name="submit" class="submit btn btn-primary">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
            var current = 1,current_step,next_step,steps;
            steps = $("fieldset").length;
            $(".next").click(function(){
                current_step = $(this).parent();
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);
            });
            $(".previous").click(function(){
                current_step = $(this).parent();
                next_step = $(this).parent().prev();
                next_step.show();
                current_step.hide();
                setProgressBar(--current);
            });
            setProgressBar(current);
            // Change progress bar action
            function setProgressBar(curStep){
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar")
                .css("width",percent+"%")
            }
            });
        </script>

<?php
    require_once '../Pages/elements/footer.php';
    } else {
        header('Location: schoolClassModule.php');
    }
}
?>