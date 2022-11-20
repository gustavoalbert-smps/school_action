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
    $teacherRepository = new PdoTeacherRepository($connection);

    $userController = new UserController($connection);

    $setLimit = 0;

    $getLimitUsersArray = $userController->getLimitUsers($userRepository, $setLimit); 

    // foreach($getLimitUsersArray as $User)
    // {
    //   print_r($User['id']);
    // }
    // print_r($getLimitUsersArray);

    $getUsersCount = $userController->getPeopleCount($peopleRepository);

    $getTeachersCount = $userController->totalUsersType('teacher');

    $getStudentsCount = $userController->totalUsersType('');

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
                <li class="list-group-item"><?= $getUsersCount ?></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="list-group-item panel-list-group">Professores</li>
                <li class="list-group-item"><?= $getTeachersCount?></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="panel-list-group list-group-item">Estudantes</li>
                <li class="list-group-item"><?= $getStudentsCount?></li>
              </ul>
            </div>
          </div>
          <div class="col">
          <div class="panel-card">
              <ul class="list-group list-group-flush text-center">
                <li class="bg-primary panel-list-group list-group-item">Coordenadores</li>
                <li class="list-group-item">3</li>
              </ul>
            </div>
          </div>
      </div>
      <!-- filtro -->
      <div class="panel-card">
        <form action="adminPanel.php" method = "POST">
          <div class="col mb-3">
            <div class="row">
              <div class="panel-form-group">
                <label for="form-control">Filtrar por Usarios: </label>
                <select class="form-control" name="" id="">
                  <option value = "filterAll">Todos</option>
                  <option value = "filterTeacher">Professores</option>
                  <option value = "filterStudent">Alunos</option>
                  <option>Coordenadores</option>
                </select>
                <div class="mb-4">
                  <label for="form-control">Quantidade de linhas: </label>
                    <select class="form-control" name="" id="">
                      <option value = "10">10</option>
                      <option value = "100">100</option>
                      <option value = "1000">1000</option>
                      <option value = "10000">10000</option>
                      <option value = "999999">999999</option>
                    </select>
                </div>

                <button class = " form-control btn btn-primary" type="submit">Enviar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- end filtro -->
      <div class="row">
        <div class="col">
          <div class="">
            <table class="panel-table table-borderless panel-table-striped text-center">
              <thead>
                <tr class = "bg-primary panel-table-header">
                  <th class = "head" scope="col">Nome</th>
                  <th class = "head" scope="col">Data de nascimento</th>
                  <th class = "head" scope="col">Sexo</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($getLimitUsersArray as $Users):?> 
                <tr class = "text-center panel-admin-tr name">
                    
                    <td class="" align="center"><a href="/pdo/src/Pages/Profile.php?id=<?= $Users['id']?>"><?= $Users['name']?></a></td>
                    <td class><a href="/pdo/src/Pages/Profile.php?id=<?= $Users['id']?>"><?= $Users['birth_date']?></td>
                    <td><a href="/pdo/src/Pages/Profile.php?id=<?= $Users['id']?>"><?= $Users['gender']?></td>
                
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