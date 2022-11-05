<?php

use Alura\Pdo\Infrastructure\Controller\UserController;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once '../../vendor/autoload.php';

session_start();

if (empty($_SESSION['user']) || empty($_SESSION['password'])) {
  $_SESSION = array();
  header('Location: /pdo/src/Pages/index.php');
} else {
  if ($_SESSION['admin'] === 1){
    $connection = ConnectDatabase::connect();

    $userRepository = new PdoUserRepository($connection);
    $peopleRepository = new PdoPeopleRepository($connection);
    $studentRepository = new PdoStudentRepository($connection);
    $eacherRepository = new PdoTeacherRepository($connection);

    $userController = new UserController($connection);

    $people = $userController->totalUsers($peopleRepository);

    $teachers = $userController->totalUsersType('teacher');

    $students = $userController->totalUsersType('');
    
    include_once 'elements/head.php';
?>
    <div class="container">
      <div class="col">
        <div class="row mb-3">
          <div class="pagetitle">
            <h1>Painel do Administrador</h1>
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <!--Card menu-->
      <div class = "row">
       <!--Card 1-->
        <div class="col">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
            <h5 class="card-title class-identifier ">Todos os Usuarios</h5>

            </div>
          </div>
        </div>
       <!--Card 2--> 
        <div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title class-identifier ">Todos os Usuarios</h5>
            </div>
          </div>
        </div>
        <!--Card 3-->
        <div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
             <h5 class="card-title class-identifier ">Todos os Usuarios</h5>
            </div>
          </div>
        </div>
        <!--Card 4-->
        <div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title class-identifier ">Todos os Usuarios</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
       <!--end menu-->

     

<?php 
    include_once 'elements/footer.php';
    } else {
      if ($_SESSION['teacher'] === 0) {
        header('Location: /pdo/src/Pages/studentsModule.php');
      } else {
        header('Location: /pdo/src/Pages/schoolClassModule.php');
      }
    }
  }
?>