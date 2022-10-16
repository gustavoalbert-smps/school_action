<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoMatterRepository;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;

require_once '../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();

$teacherRepository = new PdoTeacherRepository($connection);
$teacher = $teacherRepository->getTeacherByPeopleId($_SESSION['people_id']);

$matterRepository = new PdoMatterRepository($connection);
$matter = $matterRepository->getMatterByTeacherId($teacher->getId());

$user = $_SESSION['user'];

?>

<?php
    require_once '../Pages/elements/head.php';
?>

<ul>
    <li><a href="schoolClass.php?id=<?php echo $matter->getClassId();?>">Turmas</a></li>
    <li><img src="imgs/student-icon.svg" alt=""><a href="environments/student/studentsModule.php">Estudantes</a></li>
</ul>

<?php
    require_once '../Pages/elements/footer.php';
?>