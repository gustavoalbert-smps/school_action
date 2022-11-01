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
                    <form class="form" action="registerStudent.php" method="POST">
                        <div class="form-floating mb-3">
                            <label for="user">Nome de usuário</label>
                            <input class="form-control" type="text" name="user" id="user">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="password">Senha</label>
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="name">Nome</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="birth_date">Data de Nascimento</label>
                            <input class="form-control" type="date" name="birth_date" id="birth-date">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="gender">Sexo</label>
                            <select class="form-select" name="gender" id="gender">
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>
                        </div>
                        <div class="form-floating mb-3">
                            <label for="class">Classe pertencente</label>
                            <select class="form-select" name="class" id="class">
                                <?php foreach ($classes as $class) {?>
                                    <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button class="btn">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>

<?php
    require_once '../Pages/elements/footer.php';
    } else {
        header('Location: schoolClassModule.php');
    }
}
?>