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

      <!-- end page title -->

      <div class="row">
          <div class="col">
          <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="list-group-item">Usuarios</li>
                <li class="list-group-item">150</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="list-group-item">Professores</li>
                <li class="list-group-item">230</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="list-group-item">Estudantes</li>
                <li class="list-group-item">430</li>
              </ul>
            </div>
          </div>
          <div class="col">
          <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="list-group-item">Coordenadores</li>
                <li class="list-group-item">30</li>
              </ul>
            </div>
          </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="panel-card">
            <table class="table table-borderless text-center">
              <thead>
                <tr class = "bg-success">
                  <th scope="col">Nome</th>
                  <th scope="col">Sobrenome</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr class = "text-justify">
                  <td>Bridie Kessler</td>
                  <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                  <td>$47</td>
                  <td><span class="badge bg-warning">Pending</span></td>
                </tr>
                <tr class = "text-justify">
                  <td>Ashleigh Langosh</td>
                  <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                  <td>$147</td>
                  <td><span class="badge bg-success">Approved</span></td>
                </tr>
                <tr class = "text-justify">
                  <td>Angus Grady</td>
                  <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                  <td>$67</td>
                  <td><span class="badge bg-danger">Rejected</span></td>
                </tr>
                <tr class = "text-justify">
                  <td>Raheem Lehner</td>
                  <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                  <td>$165</td>
                  <td><span class="badge bg-success">Approved</span></td>
                </tr>
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