<?php

use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once '../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();

$userRepository = new PdoUserRepository($connection);
$peopleRepository = new PdoPeopleRepository($connection);
$studentRepository = new PdoStudentRepository($connection);
$eacherRepository = new PdoTeacherRepository($connection);

$userController = new UserController($connection);

$people = $userController->totalUsers($peopleRepository);

$teachers = $userController->totalUsersType('teacher');

$students = $userController->totalUsersType('');

$user = $_SESSION['user'];

?>

<?php include_once 'elements/head.php';?>

    <div class="pagetitle">
      <h1>Painel do Administrador</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex justify-content-around p-2">
        <div class="cardAdmin col-sm-4 mb-3" style="max-width: 18rem;">
        <div class="text-center"> 
            <img class = "rounded" src="../Pages/imgs/people.svg" alt="people" style="width: 4rem;">
        
                <div class="card-body">
                    <h5 class="card-title"><a href ="adminPanelAllUser.php">Total de usuários</a></h5>
                    <p class="card-text"><?= $people?></p>
                    <p><p></p></p>
                  </div>
                </div>
        </div>
        <div class="cardAdmin col-sm-4 mb-3" style="max-width: 18rem;">
        <div class="text-center"> 
          <img class="rounded" src="../Pages/imgs/teacher.svg" alt="teacher" style="width: 4rem;">
        
                <div class="card-body">
                    <h5 class="card-title">Professores</h5>
                    <p class="card-text"><?= $teachers?></p>
                    <p><p></p></p>
                </div>
                </div>
        </div>
        <div class="cardAdmin col-sm-4 mb-3" style="max-width: 18rem;">
        <div class="text-center">  
            <img class = "rounded" src="../Pages/imgs/group-students.svg" alt="group-students" style="width: 4rem;">
        
            <div class="card-body">
                <h5 class="card-title">Estudantes</h5>
                <p class="card-text"><?= $teachers?></p>
                <p><p></p></p>
                </div> 
            </div>
        </div>
    </div>
  </main>

  <?php include_once 'elements/footer.php';?>