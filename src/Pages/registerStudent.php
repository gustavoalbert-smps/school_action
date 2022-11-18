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
                    <div class="text-center mb-3">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped bg-primary active" role="progressbar"></div>
                    </div>
                    <form class="form" name="form" id="registration-form" onsubmit="return formValidationStep2()" action="registerUser.php" method="POST">
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
                            <div class="form-floating mb-3 school_class">
                                <label for="class">Classe pertencente</label>
                                <select class="form-select" id="school_class" name="school_class" required>
                                    <option value="default" selected>Selecione uma turma</option>
                                    <?php foreach ($classes as $class) {?>
                                        <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="masc" name="gender" value="masculino">
                                <label class="form-check-label" for="masc">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="fem" name="gender" value="feminino">
                                <label class="form-check-label" for="fem">Feminino</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="outros" name="gender" value="outros">
                                <label class="form-check-label" for="outros">Outros</label>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="birth_date">Data de Nascimento</label>
                                <input class="form-control" type="text" placeholder="Data de Nascimento" onfocus="this.type='date';" onblur="this.type='text';" name="birth_date" id="birth-date">
                            </div>
                            <input type="button" name="previous" class="previous btn btn-secondary" value="Voltar">
                            <input type="submit" name="submit" class="submit btn btn-primary">
                            <input type="hidden" name="recording-user" value="true">
                            <input type="hidden" name="form-type" value="student">
                            <input type="hidden" id="teacher" name="teacher" value="">
                            <input type="hidden" id="student" name="student" value="">
                        </fieldset>
                    </form>

                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="username-empty">
                        Nome de usuário não pode ser vazio.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="username-length">
                        Nome de usuário deve entre 5 a 15 caracteres.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="password-empty">
                        Por favor, insira uma senha.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="password-length">
                        A senha deve estar entre 6 a 12 caracteres.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="incorrect-name">
                        Insira o nome corretamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="radios-empty">
                        Por favor, marque uma opção.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="class-empty">
                        O Aluno deve estar associado a uma turma. Por favor, selecione uma.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="birth-date-empty">
                        Informe uma data de nascimento.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function formValidationStep1() {
                var username = document.getElementsByName("user")[0].value;
                var password = document.getElementsByName("password")[0].value;

                if (username.length == 0) {
                    $('#username-empty').show();
                    document.getElementsByName("user")[0].focus();
                    return false;
                } else if (username.length > 15 || username.length < 5) {
                    $('#username-length').show();
                    udocument.getElementsByName("user")[0].focus();
                    return false;
                }

                if (password.length == 0) {
                    $('#password-empty').show();
                    document.getElementsByName("password")[0].focus();
                    return false;
                } else if (password.length > 12 || password.length < 6) {
                    $('#password-length').show();
                    document.getElementsByName("password")[0].focus();
                    return false;
                }
                return true;
            }

            function formValidationStep2() {
                const form = document.getElementsByName("form");
                var username = document.getElementsByName("user")[0].value;
                var password = document.getElementsByName("password")[0].value;
                var name = document.getElementsByName("name")[0].value;
                var regName = /\d+$/g;
                var birthDate = document.getElementsByName("birth_date")[0].value;
                var radios = document.getElementsByName("gender");
                var radioValid = false;
                var classSelect = document.getElementsByName("school_class")[0].value;

                if (username.length == 0) {
                    $('#username-empty').show();
                    document.getElementsByName("user")[0].focus();
                    return false;
                } else if (username.length > 15 || username.length < 5) {
                    $('#username-length').show();
                    document.getElementsByName("user")[0].focus();
                    return false;
                }

                if (password.length == 0) {
                    $('#password-empty').show();
                    document.getElementsByName("password")[0].focus();
                    return false;
                } else if (password.length > 12 || password.length < 6) {
                    $('#password-length').show();
                    document.getElementsByName("password")[0].focus();
                    return false;
                }

                if (name.length == 0 || regName.test(name)) {
                    $('#incorrect-name').show();
                    document.getElementsByName("name")[0].focus();
                    return false;
                }

                if (classSelect == "default" || classSelect.length == 0) {
                    $('#class-empty').show();
                    document.getElementsByName("school_class")[0].focus();
                    return false;
                }
                
                var i = 0;
                while (!radioValid && i < radios.length) {
                    if (radios[i].checked) radioValid = true;
                    i++;
                }

                if (!radioValid) {
                    $('#radios-empty').show();
                    return false;
                }

                if (birthDate.length == 0) {
                    $('#birth-date-empty').show();
                    document.getElementsByName("birth_date")[0].focus();
                    return false;
                }

                return true;
            }


            $(document).ready(function(){
                var current = 1,current_step,next_step,steps;
                steps = $("fieldset").length;
                $(".next").click(function(){
                    var valid = formValidationStep1();

                    if(valid) {
                        current_step = $(this).parent();
                        next_step = $(this).parent().next();
                        next_step.show();
                        current_step.hide();
                        setProgressBar(++current);    
                    }
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