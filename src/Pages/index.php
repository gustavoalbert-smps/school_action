<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;

  require_once '../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();

$userRepository = new PdoUserRepository($connection);
$peopleRepository = new PdoPeopleRepository($connection);
$studentRepository = new PdoStudentRepository($connection);
$teacherRepository = new PdoTeacherRepository($connection);


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  if ($userRepository->isValidUser($_POST['user'], $_POST['password']))
  {
    
    $user = $userRepository->getUserByCredentials($_POST['user'], $_POST['password']);
      
      $people = $peopleRepository->getPeople($user->getPeopleId());

      $_SESSION['user'] = $user->getUser();
      $_SESSION['password'] = $user->getPassword();
      $_SESSION['teacher'] = $user->getIsTeacher();
      $_SESSION['people_id'] = $user->getReferenceId();
      $_SESSION['name'] = $people->getName();
      $_SESSION['birth_date'] = $people->getBirthDate();
      $_SESSION['gender'] = $people->getGender();
      $_SESSION['admin'] = $people->getIsAdmin();

      
      
      if ($people->getIsAdmin() === 1) 
      {
          header('Location: /pdo/src/Pages/adminPanel.php');
      } else {
          if ($user->getIsTeacher() === 0) {
              header('Location: /pdo/src/Pages/studentsModule.php');
          } else {
              header('Location: /pdo/src/Pages/schoolClassModule.php');
          }
      }
  }
  else
  {
    header('location: /elements/err-invalid-user.html');
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Escola Action</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

    <!-- falta configurar o erro para quando o usuario digitado for invalido (elements/err-invalid-user.html) -->

<body>
    
<main>
    <form action="index.php" method="POST">   
        <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Escola Action</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Faça login na sua conta</h5>
                    <p class="text-center small">Digite seu nome de usuário e senha para entrar</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Usuario</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input class="form-control" type="text" name="user" placeholder="Seu usuário">
                        <div class="invalid-feedback">Por favor insira seu nome de usuário.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Senha</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Por favor, insira sua senha!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                       <br>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Entrar</button>
                    </div>
                 </form>

                </div>
              </div>

             

            </div>
          </div>
        </div>

      </section>

    </div>
    </form>
    <p style = "text-align: center;">School Action &copy; 2022 developed by Gustavo Albert and Isaias Araujo</p>
  </main><!-- End #main -->
</body>
</html>

