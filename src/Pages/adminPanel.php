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

    $arrayPeople = $userController->Users($peopleRepository); 

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

      <!-- end page title -->


      <div class="row mt-3">
          <div class="col">
          <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="panel-list-group list-group-item">Usuarios</li>
                <li class="list-group-item"><?= $people ?></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <img src='imgs/teacher-icon.svg' alt="Image de um professor">
                <!-- <li class="list-group-item panel-list-group">Professores</li> -->
                <li class="list-group-item">Modulo Professores</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="panel-list-group list-group-item">Estudantes</li>
                <li class="list-group-item"><?= $students?></li>
              </ul>
            </div>
          </div>
          <div class="col">
          <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="panel-list-group list-group-item">Coordenadores</li>
                <li class="list-group-item">3</li>
              </ul>
            </div>
          </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="">
            <table class="panel-table table-borderless panel-table-striped text-center">
              <thead>
                <tr class = "panel-table-header">
                  <th class = "head" scope="col">Nome</th>
                  <th class = "head" scope="col">Data de nascimento</th>
                  <th class = "head" scope="col">Sexo</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($arrayPeople as $arrayPeople):?>
                <tr class = "text-center panel-admin-tr name">
                    
                    <td class="" align="center"><a href="/pdo/src/Pages/Profile.php?id=<?= $arrayPeople['id']?>"><?= $arrayPeople['name']?></a></td>
                    <td class><a href="/pdo/src/Pages/Profile.php?id=<?= $arrayPeople['id']?>"><?= $arrayPeople['birth_date']?></td>
                    <td><a href="/pdo/src/Pages/Profile.php?id=<?= $arrayPeople['id']?>"><?= $arrayPeople['gender']?></td>
                
                </tr>
                <?php endforeach?>
              </tbody>
            </table>
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