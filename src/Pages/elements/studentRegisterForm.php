<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;

require_once '../../vendor/autoload.php';

$connection = ConnectDatabase::connect();

$classRepository = new PdoSchoolClassRepository($connection);

$classes = $classRepository->allClasses();

?>

<div class="bg-white rounded-lg shadow-sm p-5">
    <div class="progress mb-3">
        <div class="progress-bar progress-bar-striped bg-primary active" role="progressbar"></div>
    </div>
    <form class="form" id="registration-form" action="registerStudent.php" method="POST">
        <fieldset>
            <div class="form-floating mb-3">
                <label for="user">Nome de usuário</label>
                <input class="form-control" type="text" name="user" id="user">
            </div>
            <div class="form-floating mb-3">
                <label for="password">Senha</label>
                <input class="form-control" type="text" name="password" id="password">
            </div>
            <input type="button" name="next" class="next btn btn-primary mb-3" value="Próximo">
        </fieldset>
        <fieldset>
            <div class="form-floating mb-3">
                <label for="name">Nome</label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="form-floating mb-3">
                <label for="birth_date">Data de Nascimento</label>
                <input class="form-control" type="text" placeholder="Data de Nascimento" onfocus="this.type='date';" onblur="this.type='text';" name="birth_date" id="birth-date">
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="masc" name="gender" value="masculino">
                <label class="form-check-label" for="masc">Masculino</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="fem" name="gender" value="masculino">
                <label class="form-check-label" for="fem">Feminino</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="outros" name="gender" value="outros">
                <label class="form-check-label" for="outros">Outros</label>
            </div>
            <div class="form-floating mb-3">
                <label for="class">Classe pertencente</label>
                <select class="form-select" name="class" id="class">
                    <?php foreach ($classes as $class) {?>
                        <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="button" name="previous" class="previous btn btn-secondary" value="Voltar">
            <input type="submit" name="submit" class="submit btn btn-primary">
        </fieldset>
    </form>
</div>