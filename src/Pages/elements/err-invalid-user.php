<?php
   
   session_start();

   $_SESSION['msg'] = "Nome de usuário ou senha inválidos";

    header('location: ..');
?>
