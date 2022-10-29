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
?>

<?php
    require_once '../Pages/elements/head.php';
?>

        <h1>Cadastrar novo aluno</h1>
        <form action="registerStudent.php" method="POST">
            <p>
                <label for="user">Nome de usuário:</label>
                <input class="form-field" type="text" name="user" id="user">
            </p>
            <p>
                <label for="password">Senha:</label>
                <input class="form-field" type="password" name="password" id="password">
            </p>
            <p>
                <label for="name">Nome:</label>
                <input class="form-field" type="text" name="name" id="name">
            </p>
            <p>
                <label for="birth_date">Data de Nascimento:</label>
                <input class="form-field" type="date" name="birth_date" id="birth-date">
            </p>
            <p>
                <label for="class">Classe pertencente:</label>
                <select name="class" id="class">
                    <?php foreach ($classes as $class) {?>
                        <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="gender">Sexo:</label>
                <select name="gender" id="gender">
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
            </p>
            <p>
                <button class="btn">Cadastrar</button>
            </p>
        </form>

<?php
    require_once '../Pages/elements/footer.php';
    }
?>