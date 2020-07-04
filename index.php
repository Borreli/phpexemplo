<?php include 'Views/cabecalho.php'; ?>

<!-- O grid deve ser incluído em container. -->
<div class="container" style="margin-top:30px">
  <!-- O grip pode ter várias linhas (row). Cada linha pode ter até 12 colunas (col). -->
  <div class="row">
    <!-- 1a coluna da linha correspondendo a 4 colunas unitárias do grid. sm para configuração do grid para visualização em dispositivos pequenos (sm = small, >= 576px). Caso o dispositivo tenha largura de tela menor que 576px, as colunas deixam de ser colunas e passam a ser empilhadas umas sobre as outras. -->
    <div class="col-sm-4">
      <h3>Links Úteis</h3>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="https://www.w3schools.com/" target="_blank">w3schools</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.php.net/manual/pt_BR/index.php" target="_blank">Manual do PHP</a>
        </li>
      </ul>
      <hr class="d-sm-none">
    </div>
    <div class="col-sm-8">
      <h2>Descrição</h2>
      <p>Exemplo de aplicação Web em PHP usado em aulas. Também utiliza Bootstrap 4.</p>
      <p>Para clonar o projeto utilize:</p>
      <p>git clone https://github.com/prtcandido/phpexemplo.git</p>
    </div>
  </div>

</div>

<?php include 'Views/rodape.php'; ?>