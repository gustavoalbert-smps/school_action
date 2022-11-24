<?php

use Alura\Pdo\Infrastructure\Controller\PeopleController;
use Alura\Pdo\Infrastructure\Controller\TeacherController;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;

require_once '../../vendor/autoload.php';

$connection = ConnectDatabase::connect();

$peopleRepository = new PdoPeopleRepository($connection);
$peopleController = new PeopleController($connection);

$teacherController = new TeacherController($connection);
$teacherRepository = new PdoTeacherRepository($connection);

header('Content-Type: application/json');

// if (isset($_POST['graduation'])) {

    $teachers = $teacherController->getTeachersWithSpecificGraduation($teacherRepository,'matematica');

    $peoples = [];

    foreach ($teachers as $teacher) {
        $people = $peopleController->getPeopleAsArray($peopleRepository, $teacher['people_id']);
        $peoples[] = $people;
    }

    echo json_encode(array('status' => 'sucess', 'data' => $teachers, 'peoples' => $peoples), JSON_UNESCAPED_UNICODE);
// }
?>