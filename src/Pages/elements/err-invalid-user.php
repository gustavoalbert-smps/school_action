<?php
   
   session_start();

   $_SESSION['msg'] = "Nome de usuário ou senha inválidos";

    header('location: ..');
?>

<!-- <div class="notification" id="invalid-user">
    <p>Usuário ou senha inválidos</p>
</div> -->