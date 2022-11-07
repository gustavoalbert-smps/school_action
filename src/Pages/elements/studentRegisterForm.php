<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;

require_once '../../vendor/autoload.php';

$connection = ConnectDatabase::connect();

$classRepository = new PdoSchoolClassRepository($connection);

$classes = $classRepository->allClasses();

?>

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