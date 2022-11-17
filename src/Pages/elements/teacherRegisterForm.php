<div class="bg-white rounded-lg shadow-sm p-5">
    <div class="progress mb-3">
        <div class="progress-bar progress-bar-striped bg-primary active" role="progressbar"></div>
    </div>
    <form class="form" id="registration-form" onsubmit="return formValidationTeacher();" action="registerUser.php" method="POST">
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
                <input class="form-check-input" type="radio" id="fem" name="gender" value="feminino">
                <label class="form-check-label" for="fem">Feminino</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" id="outros" name="gender" value="outros">
                <label class="form-check-label" for="outros">Outros</label>
            </div>
            <div class="form-floating mb-3">
                <label for="graduation">Formação</label>
                <input class="form-control" type="text" id="graduation" name="graduation">
            </div>
            <input type="button" name="previous" class="previous btn btn-secondary" value="Voltar">
            <input type="submit" name="submit" class="submit btn btn-primary">
            <input type="hidden" id="recording-user" name="recording-user" value="true">
            <input type="hidden" name="form-type" value="teacher">
            <input type="hidden" id="teacher" name="teacher" value="">
            <input type="hidden" id="student" name="student" value="">
        </fieldset>
    </form>

    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="username-empty">
        Nome de usuário não pode ser vazio.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="username-length">
        Nome de usuário deve entre 5 a 15 caracteres.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="password-empty">
        Por favor, insira uma senha.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="password-length">
        A senha deve estar entre 6 a 12 caracteres.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="incorrect-name">
        Insira o nome corretamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="birth-date-empty">
        Informe uma data de nascimento.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="radios-empty">
        Por favor, marque uma opção.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show registration-alert" role="alert" id="graduation-empty">
        Informe a formação do professor!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

<script>

    function formValidationUser() {
        var username = document.getElementsByName("user")[0].value;
        var password = document.getElementsByName("password")[0].value;
        
        if (username.length == 0) {
            $('#username-empty').show();
            document.getElementsByName("user")[0].focus();
            return false;
        } else if (username.length > 15 || username.length < 5) {
            $('#username-length').show();
            udocument.getElementsByName("user")[0].focus();
            return false;
        }

        if (password.length == 0) {
            $('#password-empty').show();
            document.getElementsByName("password")[0].focus();
            return false;
        } else if (password.length > 12 || password.length < 6) {
            $('#password-length').show();
            document.getElementsByName("password")[0].focus();
            return false;
        }
        return true;
    }

    function formValidationTeacher() {
        var username = document.getElementsByName("user")[0].value;
        var password = document.getElementsByName("password")[0].value;
        var name = document.getElementsByName("name")[0].value;
        var regName = /\d+$/g;
        var birthDate = document.getElementsByName("birth_date")[0].value;
        var radios = document.getElementsByName("gender");
        var radioValid = false;
        var graduation = document.getElementsByName("graduation")[0].value;

        if (username.length == 0) {
            $('#username-empty').show();
            document.getElementsByName("user")[0].focus();
            return false;
        } else if (username.length > 15 || username.length < 5) {
            $('#username-length').show();
            document.getElementsByName("user")[0].focus();
            return false;
        }

        if (password.length == 0) {
            $('#password-empty').show();
            document.getElementsByName("password")[0].focus();
            return false;
        } else if (password.length > 12 || password.length < 6) {
            $('#password-length').show();
            document.getElementsByName("password")[0].focus();
            return false;
        }

        if (name.length == 0 || regName.test(name)) {
            $('#incorrect-name').show();
            document.getElementsByName("name")[0].focus();
            return false;
        }

        if (birthDate.length == 0) {
            $('#birth-date-empty').show();
            document.getElementsByName("birth_date")[0].focus();
            return false;
        }

        var i = 0;
        while (!radioValid && i < radios.length) {
            if (radios[i].checked) radioValid = true;
            i++;
        }

        if (!radioValid) {
            $('#radios-empty').show();
            return false;
        }

        if (graduation.length == 0) {
            $('#graduation-empty').show();
            document.getElementsByName("graduation")[0].focus();
            return false;
        }
        return true;
    }


    $(document).ready(function(){
        var current = 1,current_step,next_step,steps;
        steps = $("fieldset").length;
        $(".next").click(function(){
            var valid = formValidationUser();

            if(valid) {
                current_step = $(this).parent();
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);    
            }
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