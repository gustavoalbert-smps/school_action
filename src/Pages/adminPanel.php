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
      <div class="">  
        <div class="col">
          <div class="row mb-3">
            <div class = "mb-3">
              <h1>Bem Vindo(a) ao School Action!</h1>
              <h5>Aqui você encontra todas as ferramentas de configurações do sistema</h5>
            </div>
            <div class = "col">
                <div class="row">
                      <ul class = "list-group mx-3" >
                        <li class="list-group-item active"> <h6><i class="fa-solid fa-user-tie mx-2"></i>Professor</h6></li>  
                        <li class="list-group-item">Cadastrar</li>
                        <li class="list-group-item">Atualizar</li>
                        <li class="list-group-item">Apagar</li>
                      </ul>
                </div>
            </div>
            <div class = "col">
                <div class="row">
                </div>
                <div class="row">
                      <ul class = "list-group mx-3" >
                        <li class="list-group-item active"> <h6><i class="bi bi-file-earmark"></i>Aluno</h6></li>  
                        <li class="list-group-item">Cadastrar</li>
                        <li class="list-group-item">Atualizar</li>
                        <li class="list-group-item">Apagar</li>
                      </ul>
                </div>
            </div>
            <div class = "col">
                <div class="row">
                </div>
                <div class="row">
                      <ul class = "list-group mx-3" >
                        <li class="list-group-item active"> <h6><i class="fa-solid fa-book"></i> Disciplinas</h6></li>  
                        <li class="list-group-item">Cadastrar</li>
                        <li class="list-group-item">Atualizar</li>
                        <li class="list-group-item">Apagar</li>
                      </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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