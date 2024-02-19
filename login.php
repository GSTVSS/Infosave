<?php
session_start();
include('config/conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>InfoSave - System</title>
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="w-100 m-auto form-container">
      <form class="needs-validation" novalidate method="POST" action="valida.php">
        <div class="container"><img src="assets/css/imagens/logo.svg" alt="logo" class="mb-4" height="227" width="172"/></div>

        <div class="form-floating">
          <input type="text" class="form-control" id="floatingInput" name="usuario" placeholder="Informe seu usuário" required>
          <label for="floatingInput">Usuário</label>
          <div class="invalid-feedback">Usuário Invalido.</div>
        </div>
        <br>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Password" required>
          <label for="floatingPassword">Senha</label>
          <div class="invalid-feedback">Senha Invalida.</div>
        </div>
        
        <div class="form-check text-start my-3">
          <input type="checkbox" class="form-check-input" id="flexCheckDefault"/>
          <label class="form-check-label" for="floatingImput">Lembrar Novamente</label>
        </div>
        <div class="copy">
        <button class="btn btn-primary w-100 py-2">Entrar</button>
          <p class="mt-5 mb-1 text-muted">&copy; 2024 - <?php echo date('Y') ?></p>
          <p class="mt-1 mb-1 text-muted">InfoSystem - All Rights Reserved</p>
          <p class="mt-1 mb-1 text-muted">Versão - Beta 1.0</p>
        </div>
      </form>
    </main>
  </body>
</html>

<script>
 // SCRIPT DE VALIDAÇÃO DO PROPRIO BOOTSTRAP
  (function() {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>