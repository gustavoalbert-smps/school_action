<div class="bg-white rounded-lg shadow-sm p-5">
    <div class="progress mb-3">
        <div class="progress-bar progress-bar-striped bg-primary active" role="progressbar"></div>
    </div>
    <form class="form" id="registration-form" action="registerUser.php" method="POST">
        <fieldset>
            <div class="form-floating mb-3">
                <label for="user">Nome de usuário</label>
                <input class="form-control" type="text" name="user" id="user" required>
            </div>
            <div class="form-floating mb-3">
                <label for="password">Senha</label>
                <input class="form-control" type="text" name="password" id="password" required>
            </div>
            <input type="button" name="next" class="next btn btn-primary mb-3" value="Próximo">
        </fieldset>
        <fieldset>
            <div class="form-floating mb-3">
                <label for="name">Nome</label>
                <input class="form-control" type="text" name="name" id="name" required>
            </div>
            <div class="form-floating mb-3">
                <label for="birth_date">Data de Nascimento</label>
                <input class="form-control" type="text" placeholder="Data de Nascimento" onfocus="this.type='date';" onblur="this.type='text';" name="birth_date" id="birth-date" required>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="masc" name="gender" value="masculino">
                <label class="form-check-label" for="masc">Masculino</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="fem" name="gender" value="masculino" >
                <label class="form-check-label" for="fem">Feminino</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="outros" name="gender" value="outros">
                <label class="form-check-label" for="outros">Outros</label>
            </div>
            <div class="form-floating mb-3">
                <label for="class">Classe pertencente</label>
                <select class="form-select" id="class" name="class" required>
                    <?php foreach ($classes as $class) {?>
                        <option value="<?php echo $class->getId()?>"><?php echo "{$class->getYear()}{$class->getIdentifier()}"?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="button" name="previous" class="previous btn btn-secondary" value="Voltar">
            <input type="submit" name="submit" class="submit btn btn-primary">
            <input type="hidden" name="recording-user" value="true">
            <input type="hidden" name="form-type" value="student">
            <input type="hidden" id="teacher" name="teacher" value="">
            <input type="hidden" id="student" name="student" value="">
        </fieldset>
    </form>

    <script>
        $(document).ready(function(){
        var current = 1,current_step,next_step,steps;
        steps = $("fieldset").length;
        $(".next").click(function(){
            current_step = $(this).parent();
            next_step = $(this).parent().next();
            next_step.show();
            current_step.hide();
            setProgressBar(++current);
        });
        $(".previous").click(function(){
            current_step = $(this).parent();
            next_step = $(this).parent().prev();
            next_step.show();
            current_step.hide();
            setProgressBar(--current);
        });
        setProgressBar(current);
        // Change progress bar action
        function setProgressBar(curStep){
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
            .css("width",percent+"%")
        }
        });
    </script>
</div>