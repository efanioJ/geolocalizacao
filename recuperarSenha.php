<?php
    require_once 'Model/s_reserva.php';
    ini_set('default_charset','UTF-8');

    ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link rel="stylesheet" href="./css/estilo/estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="refresh" content="600"/>
    <title>Recuperação de Senha</title>
</head>

<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary mb-4">
          <a class="navbar-brand" href="#">S.R.V.</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
              
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <ul class="navbar-nav mr-auto">
                    
                    <li class="nav-item active">
                    <a  class="btn btn-danger my-2 my-sm-0" href="index.php">Sair</a>
                    </li>  
                </ul>
            
            </form>  
          </div>
      </nav>
    
    <br>
    <br>
    <br>
    <br>
    <main role="main" class="container">
        <div class="jumbotron">
            <h1>Digite o seu e-mail:</h1>
            <p class="lead">Será gerado uma nova senha e enviado para o e-mail informado.</p>
            
            <form id="formCadastrar" action="" method="post">  
                <form class="form-signin">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="email" class="lead">E-mail<span class="corCamposObri">*</span></label>
                            <input type="email" name="email" id="email" class="form-control lead" id="email" placeholder="exemplo@exemplo.com">
                        </div>
                        <div class="form-group col-md-3 align-self-end ">
                            <button type="submit"  name = "enviar" id="enviar" role="button" class="btn btn-primary botao1 estiloFonte">Enviar</button>
                        </div>
                    </div>
                    
                    <br>
                    <?php
                      $s_reserva = new s_reserva();
                      
                      if(isset($_POST["enviar"])){
                          
                          $email = $_POST["email"];
                          $s_reserva->setEmail($email);
                          $s_reserva->recuperSenha();
                                     
                             
                      }
                ?>
                      
                </form>  
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="../js/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/validacaoJQ/calendario.js"></script>
</body>

</html>