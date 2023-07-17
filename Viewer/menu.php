<?php
    require_once '../Model/validacao_login.php';
    require_once '../Model/s_locais.php';
    

?>
  
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary mb-4">
      <a class="navbar-brand" href="#">GEOLOCA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="locais.php">Locais <span class="sr-only">(current)</span></a>
          </li>
        </ul>
          <form class="form-inline mt-2 mt-md-0">
            <a  class="btn btn-danger my-2 my-sm-0" href="logoff.php">Sair</a>
        </form>
          
      </div>
  </nav>


