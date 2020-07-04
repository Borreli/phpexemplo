<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <meta charset="utf-8">

  <!-- Ajustar viewport conforme dimensões do dispositivo (smartphone, tablet, notebook, etc.) -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Referenciar as bibliotecas necessárias para usar o Bootstrap. -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  
</head>
<style type="text/css">
  .jumbotron {background-color: #ddddff;}
</style>
<body>
<!-- Caixa grande usada para destacar conteúdo especial da página. -->
<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Exemplo PHP</h1>
  <h4>Fatec Praia Grande</h4>
  <h5>Linguagem de programação IV (Noturno)</h5> 
</div>

<!-- Barra de navegação com links para outras páginas e com apresentação diferenciada em dispositivos de diferentes tamanhos (testar reduzindo a janela do navegador) -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Menu</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/phpexemplo">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Views/pessoa.index.php">Pessoa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Projeto</a>
      </li>
    </ul>
  </div>  
</nav>